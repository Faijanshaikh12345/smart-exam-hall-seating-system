<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class HallSeat extends Model
{
    protected $fillable = [
        'exam_hall_id',
        'seat_number',
        'row_number',
        'column_number',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'row_number' => 'integer',
            'column_number' => 'integer',
        ];
    }

    public function examHall(): BelongsTo
    {
        return $this->belongsTo(ExamHall::class);
    }

    public function seatingArrangements(): HasMany
    {
        return $this->hasMany(SeatingArrangement::class);
    }
}
