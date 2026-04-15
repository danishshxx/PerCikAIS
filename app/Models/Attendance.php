<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    use HasFactory;

    // Tambahin ini biar datanya bisa di-insert
    protected $fillable = [
        'user_id',
        'subject_name',
        'attendance_date',
        'status',
    ];
}