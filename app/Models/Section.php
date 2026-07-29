<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int $id
 * @property int $course_id
 * @property string $title
 * @property int $position
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 *
 * @property-read Course $course
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Lesson> $lessons
 */
class Section extends Model
{
    use HasFactory;

    protected $fillable = [
        'course_id',
        'title',
        'position',
    ];

    protected function casts(): array
    {
        return [
            'course_id' => 'integer',
            'position'  => 'integer',
        ];
    }

    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }

    public function lessons(): HasMany
    {
        return $this->hasMany(Lesson::class)
            ->orderBy('position');
    }

    /**
     * Следующая позиция внутри курса.
     */
    public static function nextPosition(int $courseId): int
    {
        return (int) static::query()
            ->where('course_id', $courseId)
            ->max('position') + 1;
    }
}