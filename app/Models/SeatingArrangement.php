<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SeatingArrangement extends Model
{
    protected $fillable = [
        'exam_id',
        'student_id',
        'exam_hall_id',
        'hall_seat_id',
        'subject_id',
        'assigned_at',
    ];

    protected function casts(): array
    {
        return [
            'assigned_at' => 'datetime',
        ];
    }

    public function exam(): BelongsTo
    {
        return $this->belongsTo(Exam::class);
    }

    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }

    public function examHall(): BelongsTo
    {
        return $this->belongsTo(ExamHall::class);
    }

    public function hallSeat(): BelongsTo
    {
        return $this->belongsTo(HallSeat::class);
    }

    public function subject(): BelongsTo
    {
        return $this->belongsTo(Subject::class);
    }

    public function conflicts(): HasMany
    {
        return $this->hasMany(Conflict::class);
    }
}
