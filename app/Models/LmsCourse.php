<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LmsCourse extends Model
{
    use HasFactory;

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
        return $this->belongsTo(LmsUser::class, 'teacherId', 'id');
    }
}