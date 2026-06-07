<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    protected $table = 'User';
    public $incrementing = false;
    protected $keyType = 'string';

    const CREATED_AT = 'createdAt';
    const UPDATED_AT = 'updatedAt';

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'profile_photo_path',
        'nis',
        'phone',
        'gender',
        'birth_place',
        'birth_date',
        'address',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'birth_date' => 'date',
        ];
    }

    protected static function booted()
    {
        static::creating(function ($user) {
            if (empty($user->id)) {
                $user->id = 'c' . substr(str_replace('-', '', (string) \Illuminate\Support\Str::uuid()), 0, 24);
            }
        });
    }

    public function getRoleAttribute($value): string
    {
        return strtolower($value);
    }

    public function setRoleAttribute($value): void
    {
        $this->attributes['role'] = strtoupper($value);
    }

    public function getProfilePhotoUrlAttribute(): string
    {
        if ($this->profile_photo_path && Storage::disk('public')->exists($this->profile_photo_path)) {
            return '/storage/' . $this->profile_photo_path;
        }

        return 'https://ui-avatars.com/api/?name=' . urlencode($this->name ?? 'User') . '&background=2563eb&color=fff&bold=true';
    }

    public function getCreatedAtAttribute()
    {
        return $this->asDateTime($this->attributes['createdAt'] ?? null);
    }

    public function getUpdatedAtAttribute()
    {
        return $this->asDateTime($this->attributes['updatedAt'] ?? null);
    }

    public function getRustUserIdAttribute()
    {
        return $this->id;
    }

    public function getPasswordAttribute($value)
    {
        if (str_starts_with($value, '$2a$')) {
            return str_replace('$2a$', '$2y$', $value);
        }
        if (str_starts_with($value, '$2b$')) {
            return str_replace('$2b$', '$2y$', $value);
        }
        return $value;
    }

    public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }

    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }

    public function hasUnpaidInvoices(): bool
    {
        return $this->invoices()
            ->where('status', 'pending')
            ->exists();
    }

    public function isAdmin(): bool
    {
        return strtolower((string) $this->role) === 'admin';
    }

    public function isTeacher(): bool
    {
        return strtolower((string) $this->role) === 'teacher';
    }

    public function isStudent(): bool
    {
        return strtolower((string) $this->role) === 'student';
    }
}