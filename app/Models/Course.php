<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use App\Enums\CourseLevel;
use App\Enums\CourseStatus;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;


/**
 * @property int $id
 * @property string $title
 * @property string $slug
 * @property CourseLevel $level
 * @property CourseStatus $status
 * @property \Illuminate\Support\Carbon|null $published_at
 *
 * @property-read User $author
 * @property-read Category $category
 * @property-read Collection<int, Section> $sections
 * @property-read Collection<int, Enrollment> $enrollments
 * @property-read Collection<int, User> $students
 *
 * @method static Builder<static> published()
 */
class Course extends Model
{
    use HasFactory;
    protected $fillable = [
        'author_id',
        'category_id',
        'title',
        'slug',
        'short_description',
        'description',
        'thumbnail',
        'price',
        'level',
        'status',
        'published_at',
    ];

    protected $casts = [
        'published_at' => 'datetime',
        'price' => 'decimal:2',
        'level' => CourseLevel::class,
        'status' => CourseStatus::class,
    ];

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function sections(): HasMany
    {
        return $this->hasMany(Section::class)
            ->orderBy('position');
    }

    public function enrollments(): HasMany
    {
        return $this->hasMany(
            Enrollment::class
        );
    }

    public function students(): BelongsToMany
    {
        return $this->belongsToMany(
            User::class,
            'enrollments'
        );
    }
    public function scopePublished(Builder $query): Builder
    {
        return $query
            ->where('status', CourseStatus::Published)
            ->whereNotNull('published_at');
    }    

}
