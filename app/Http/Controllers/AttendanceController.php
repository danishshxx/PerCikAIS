<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class AttendanceController extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'attendance_date' => 'date',
        'is_verified' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getAbsenceLetterUrlAttribute(): ?string
    {
        if (! $this->absence_letter_path) {
            return null;
        }

        return Storage::disk('public')->exists($this->absence_letter_path)
            ? asset('storage/' . $this->absence_letter_path)
            : null;
    }
}