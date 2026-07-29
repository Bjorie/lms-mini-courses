<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int $id
 * @property int $section_id
 * @property string $title
 * @property string $slug
 * @property string|null $content
 * @property string|null $video_url
 * @property int $duration
 * @property int $position
 * @property bool $is_free
 * @property string|null $type
 * @property \Illuminate\Support\Carbon|null $published_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 *
 * @property-read Section $section
 * @property-read \Illuminate\Database\Eloquent\Collection<int, LessonProgress> $progress
 */
class Lesson extends Model
{

    use HasFactory;

    protected $fillable = [
        'section_id',
        'title',
        'slug',
        'content',
        'video_url',
        'duration',
        'position',
        'is_free',
        'published_at',
        'type'
    ];

    protected function casts(): array
    {
        return [
            'duration' => 'integer',
            'position' => 'integer',
            'is_free' => 'boolean',
            'published_at' => 'datetime',
        ];
    }

    public function section(): BelongsTo
    {
        return $this->belongsTo(Section::class);
    }
    public function progress(): HasMany
    {
        return $this->hasMany(LessonProgress::class);
    }

}
