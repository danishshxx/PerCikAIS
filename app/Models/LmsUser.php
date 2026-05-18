<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LmsUser extends Model
{
    protected $connection = 'mysql_lms';

    protected $table = 'User';

    protected $primaryKey = 'id';

    public $incrementing = false;

    protected $keyType = 'string';

    public $timestamps = false;

    protected $fillable = [
        'id',
        'name',
        'email',
        'role',
    ];
}