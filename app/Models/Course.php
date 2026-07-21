<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Enums\CourseLevel;
use App\Enums\CourseStatus;

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
    
}
