<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Student extends Model
{
    protected $fillable = [
        'user_id',
        'department_id',
        'student_code',
        'phone',
        'semester',
        'academic_year',
        'status',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class);
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
