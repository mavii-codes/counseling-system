<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CounselingCase extends Model
{
    use HasFactory;

    public const CATEGORY_ACADEMIC = 'academic';

    public const CATEGORY_PERSONAL = 'personal';

    public const STATUS_OPEN = 'open';

    public const STATUS_ACTIVE = 'active';

    public const STATUS_RESOLVED = 'resolved';

    public const STATUS_CLOSED = 'closed';

    protected $fillable = [
        'student_id',
        'counselor_id',
        'title',
        'category',
        'status',
        'summary',
        'opened_at',
        'closed_at',
    ];

    protected function casts(): array
    {
        return [
            'opened_at' => 'datetime',
            'closed_at' => 'datetime',
        ];
    }

    /**
     * @return BelongsTo<Student, $this>
     */
    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }

    /**
     * @return BelongsTo<User, $this>
     */
    public function counselor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'counselor_id');
    }

    /**
     * @return HasMany<CounselingSession, $this>
     */
    public function counselingSessions(): HasMany
    {
        return $this->hasMany(CounselingSession::class)->orderByDesc('session_at');
    }

    public static function categories(): array
    {
        return [
            self::CATEGORY_ACADEMIC => 'Academic',
            self::CATEGORY_PERSONAL => 'Personal',
        ];
    }

    public static function statuses(): array
    {
        return [
            self::STATUS_OPEN => 'Open',
            self::STATUS_ACTIVE => 'Active',
            self::STATUS_RESOLVED => 'Resolved',
            self::STATUS_CLOSED => 'Closed',
        ];
    }
}
