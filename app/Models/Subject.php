<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Subject extends Model
{
    protected $fillable = [
        'department_id',
        'name',
        'code',
        'semester',
        'credits',
        'description',
    ];

    protected function casts(): array
    {
        return [
            'credits' => 'integer',
        ];
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
}
