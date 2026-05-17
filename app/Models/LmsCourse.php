<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LmsCourse extends Model
{
    use HasFactory;

    protected $connection = 'mysql_lms';

    public $timestamps = false;

    protected $table = 'Course';

    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $guarded = [];
}