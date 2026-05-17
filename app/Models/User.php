<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;

#[Fillable(['id', 'name', 'email', 'password', 'role', 'nisn', 'kelas', 'name',
'profile_photo_path',
'phone',
'gender',
'birth_place',
'birth_date',
'address',])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    // Unified DB: Prisma-style User table with string IDs
    // protected $table = 'User';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;
    const CREATED_AT = 'createdAt';
    const UPDATED_AT = 'updatedAt';

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            if (empty($model->id)) {
                $model->id = 'c' . substr(str_replace('-', '', Str::uuid()->toString()), 0, 24);
            }
            if (empty($model->role)) {
                $model->role = 'STUDENT';
            }
        });
    }

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'birth_date' => 'date',
        ];
    }

    public function getProfilePhotoUrlAttribute(): string
    {
        if ($this->profile_photo_path) {
            return asset('storage/' . $this->profile_photo_path);
        }

        return 'https://ui-avatars.com/api/?name=' . urlencode($this->name ?? 'User') . '&background=2563eb&color=fff&bold=true';
    }

    public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }

    public function hasUnpaidInvoices()
    {
        return $this->invoices()->where('status', 'pending')->exists();
    }

    public function isAdmin()
    {
        return $this->role === 'ADMIN';
    }

    public function isTeacher()
    {
        return $this->role === 'TEACHER';
    }

    public function isStudent()
    {
        return $this->role === 'STUDENT';
    }
}
