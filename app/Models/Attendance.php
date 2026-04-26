<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    use HasFactory;

    protected $guarded = []; // Buka gembok keamanan mass assignment

    // Relasi: Absen ini punya 1 siswa
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}   