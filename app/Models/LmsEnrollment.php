<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LmsEnrollment extends Model
{
    protected $connection = 'mysql_lms';

    protected $table = 'Enrollment';

    protected $primaryKey = 'id';

    public $incrementing = false;

    protected $keyType = 'string';

    public $timestamps = false;

    protected $guarded = [];
}