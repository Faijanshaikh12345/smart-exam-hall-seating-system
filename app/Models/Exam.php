<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Exam extends Model
{
    protected $fillable = [
        'name',
        'exam_code',
        'exam_date',
        'start_time',
        'end_time',
        'exam_type',
        'academic_year',
        'status',
        'description',
    ];

    protected function casts(): array
    {
        return [
            'exam_date' => 'date',
        ];
    }

    public function registrations(): HasMany
    {
        return $this->hasMany(ExamRegistration::class);
    }

    public function seatingArrangements(): HasMany
    {
        return $this->hasMany(SeatingArrangement::class);
    }

    public function conflicts(): HasMany
    {
        return $this->hasMany(Conflict::class);
    }
}
