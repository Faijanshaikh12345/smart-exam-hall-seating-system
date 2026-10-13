<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ExamHall extends Model
{
    protected $fillable = [
        'name',
        'hall_code',
        'building',
        'floor',
        'capacity',
        'status',
        'description',
    ];

    protected function casts(): array
    {
        return [
            'capacity' => 'integer',
        ];
    }

    public function seats(): HasMany
    {
        return $this->hasMany(HallSeat::class);
    }

    public function seatingArrangements(): HasMany
    {
        return $this->hasMany(SeatingArrangement::class);
    }
}
