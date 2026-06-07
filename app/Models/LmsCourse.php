<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LmsCourse extends Model
{
    protected $connection = 'mysql_lms';

    protected $table = 'Course';

    protected $primaryKey = 'id';

    public $incrementing = false;

    protected $keyType = 'string';

    public $timestamps = false;

    protected $fillable = [
        'id',
        'title',
        'description',
        'thumbnail',
        'teacherId',
        'createdAt',
    ];

    public function teacher()
    {
        return $this->belongsTo(User::class, 'teacherId', 'id');
    }
}