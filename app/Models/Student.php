<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Student extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_number',
        'name',
        'email',
        'phone',
        'program',
        'year_level',
        'notes',
    ];

    /**
     * @return HasMany<CounselingCase, $this>
     */
    public function counselingCases(): HasMany
    {
        return $this->hasMany(CounselingCase::class);
    }
}
