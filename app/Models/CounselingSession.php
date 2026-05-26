<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CounselingSession extends Model
{
    use HasFactory;

    protected $fillable = [
        'counseling_case_id',
        'session_at',
        'duration_minutes',
        'notes',
        'next_steps',
    ];

    protected function casts(): array
    {
        return [
            'session_at' => 'datetime',
        ];
    }

    /**
     * @return BelongsTo<CounselingCase, $this>
     */
    public function counselingCase(): BelongsTo
    {
        return $this->belongsTo(CounselingCase::class);
    }
}
