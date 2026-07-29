<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property int $user_id
 * @property int $course_id
 * @property string $paid_amount
 * @property Carbon $enrolled_at
 * @property Carbon|null $completed_at
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property-read User $user
 * @property-read Course $course
 */
class Enrollment extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'course_id',
        'paid_amount',
        'enrolled_at',
        'completed_at',
    ];

    protected function casts(): array
    {
        return [
            'paid_amount' => 'decimal:2',
            'enrolled_at' => 'datetime',
            'completed_at' => 'datetime',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }
}