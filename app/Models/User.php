<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Carbon;
use Spatie\Permission\Traits\HasRoles;

/**
 * @property int $id
 * @property string $name
 * @property string $email
 * @property Carbon|null $email_verified_at
 * @property string $password
 * @property string|null $remember_token
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property-read Collection<int, Course> $authoredCourses
 * @property-read Collection<int, Enrollment> $enrollments
 * @property-read Collection<int, Course> $enrolledCourses
 * @property-read Collection<int, LessonProgress> $lessonProgress
 */
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory;
    use HasRoles;
    use Notifiable;

    /**
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Курсы, созданные пользователем как автором.
     */
    public function authoredCourses(): HasMany
    {
        return $this->hasMany(Course::class, 'author_id');
    }

    /**
     * Записи пользователя на курсы.
     */
    public function enrollments(): HasMany
    {
        return $this->hasMany(Enrollment::class);
    }

    /**
     * Курсы, на которые записан пользователь.
     */
    public function enrolledCourses(): BelongsToMany
    {
        return $this->belongsToMany(Course::class, 'enrollments');
    }

    /**
     * Прогресс пользователя по урокам.
     */
    public function lessonProgress(): HasMany
    {
        return $this->hasMany(LessonProgress::class);
    }

    /**
     * Проверяет, записан ли пользователь на указанный курс.
     */
    public function hasAccessToCourse(Course $course): bool
    {
        return $this->enrollments()
            ->whereBelongsTo($course)
            ->exists();
    }

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}