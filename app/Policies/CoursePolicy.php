<?php

namespace App\Policies;

use App\Models\Course;
use App\Models\User;

class CoursePolicy
{
    /**
     * Администратор получает полный доступ ко всем действиям.
     */
    public function before(User $user, string $ability): bool|null
    {
        if ($user->hasRole('admin')) {
            return true;
        }

        return null;
    }

    /**
     * Просмотр списка курсов в панели управления.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasRole('author');
    }

    /**
     * Просмотр конкретного курса.
     *
     * Опубликованный курс доступен любому авторизованному пользователю.
     * Неопубликованный курс доступен только его автору.
     */
    public function view(User $user, Course $course): bool
    {
        if ($course->published_at !== null) {
            return true;
        }

        return $this->ownsCourse($user, $course);
    }

    /**
     * Создание курса.
     */
    public function create(User $user): bool
    {
        return $user->hasRole('author');
    }

    /**
     * Редактирование курса.
     */
    public function update(User $user, Course $course): bool
    {
        return $user->hasRole('author')
            && $this->ownsCourse($user, $course);
    }

    /**
     * Удаление курса.
     */
    public function delete(User $user, Course $course): bool
    {
        return $user->hasRole('author')
            && $this->ownsCourse($user, $course);
    }

    /**
     * Восстановление курса.
     */
    public function restore(User $user, Course $course): bool
    {
        return $user->hasRole('author')
            && $this->ownsCourse($user, $course);
    }

    /**
     * Полное удаление курса.
     */
    public function forceDelete(User $user, Course $course): bool
    {
        return $user->hasRole('author')
            && $this->ownsCourse($user, $course);
    }

    /**
     * Публикация и снятие курса с публикации.
     */
    public function publish(User $user, Course $course): bool
    {
        return $user->hasRole('author')
            && $this->ownsCourse($user, $course);
    }

    private function ownsCourse(User $user, Course $course): bool
    {
        return (int) $course->author_id === (int) $user->id;
    }
}