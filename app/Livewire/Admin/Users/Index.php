<?php

namespace App\Livewire\Admin\Users;

use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public string $search = '';

    public string $role = '';

    public int $perPage = 10;

    /**
     * Доступные роли пользователей.
     *
     * @var array<int, string>
     */
    public array $roles = [
        'admin',
        'author',
        'student',
    ];

    public function updatedSearch(): void
    {
        $this->resetPage();
    }

    public function updatedRole(): void
    {
        $this->resetPage();
    }

    public function updatedPerPage(): void
    {
        $this->resetPage();
    }

    /**
     * Изменить роль пользователя.
     */
    public function updateRole(int $userId, string $role): void
    {
        $validated = validator(
            ['role' => $role],
            [
                'role' => [
                    'required',
                    Rule::in($this->roles),
                ],
            ]
        )->validate();

        $user = User::query()->findOrFail($userId);
        $newRole = $validated['role'];

        if ($user->id === auth()->id() && $newRole !== 'admin') {
            session()->flash(
                'error',
                'Нельзя снять роль администратора со своей учётной записи.'
            );

            return;
        }

        if (
            $user->hasRole('admin')
            && $newRole !== 'admin'
            && User::role('admin')->count() <= 1
        ) {
            session()->flash(
                'error',
                'Нельзя изменить роль последнего администратора.'
            );

            return;
        }

        $user->syncRoles([$newRole]);

        session()->flash(
            'success',
            'Роль пользователя успешно изменена.'
        );
    }

    /**
     * Удалить пользователя без потери связанных учебных данных.
     */
    public function delete(int $userId): void
    {
        $user = User::query()
            ->withCount([
                'enrolledCourses',
                'enrollments',
                'lessonProgress',
            ])
            ->findOrFail($userId);

        if ($user->id === auth()->id()) {
            session()->flash(
                'error',
                'Нельзя удалить свою учётную запись.'
            );

            return;
        }

        if (
            $user->hasRole('admin')
            && User::role('admin')->count() <= 1
        ) {
            session()->flash(
                'error',
                'Нельзя удалить последнего администратора.'
            );

            return;
        }

        if (
            $user->enrolled_courses_count > 0
            || $user->enrollments_count > 0
            || $user->lesson_progress_count > 0
        ) {
            session()->flash(
                'error',
                'Нельзя удалить пользователя, пока с ним связаны курсы или данные обучения.'
            );

            return;
        }

        try {
            DB::transaction(function () use ($user): void {
                $user->syncRoles([]);
                $user->delete();
            });

            session()->flash(
                'success',
                'Пользователь успешно удалён.'
            );
        } catch (QueryException) {
            session()->flash(
                'error',
                'Не удалось удалить пользователя из-за связанных данных.'
            );
        }
    }

    public function render()
    {
        $search = trim($this->search);

        $users = User::query()
            ->with('roles:id,name')
            ->withCount('enrolledCourses')
            ->when(
                $search !== '',
                fn (Builder $query) => $query->where(
                    fn (Builder $query) => $query
                        ->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%")
                )
            )
            ->when(
                $this->role !== '',
                fn (Builder $query) => $query->role($this->role)
            )
            ->latest()
            ->paginate($this->perPage);

        return view('livewire.admin.users.index', [
            'users' => $users,
            'usersCount' => User::query()->count(),
            'studentsCount' => User::role('student')->count(),
            'authorsCount' => User::role('author')->count(),
            'adminsCount' => User::role('admin')->count(),
        ])->layout('layouts.app');
    }
}