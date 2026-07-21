<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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
        'type',
    ];

    protected $casts = [
        'is_free' => 'boolean',
        'published_at' => 'datetime',
    ];

    public function section(): BelongsTo
    {
        return $this->belongsTo(Section::class);
    }
}
