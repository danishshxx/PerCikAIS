<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LmsCourse extends Model
{
    use HasFactory;

    // Use the LMS database connection
    // protected $connection = 'mysql_lms';

    public $timestamps = false;

    // Specify the table name (Prisma defaults to PascalCase or exactly as defined)
    protected $table = 'Course';

    // The primary key is 'id' (cuid string)
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';

    // Prisma uses 'createdAt' and 'updatedAt' instead of 'created_at' and 'updated_at'
    const CREATED_AT = 'createdAt';
    const UPDATED_AT = 'updatedAt';

    protected $guarded = [];
}
