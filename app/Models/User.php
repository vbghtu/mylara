<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Enums\UserRole;
use App\Enums\UserStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'status',
        'profile_photo',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    // Scope методы для удобной фильтрации
    private mixed $role;

    public function scopeAdmins($query)
    {
        return $query->where('role', UserRole::ADMIN);
    }

    public function scopeModerators($query)
    {
        return $query->where('role', UserRole::MODERATOR);
    }

    public function scopeUsers($query)
    {
        return $query->where('role', UserRole::USER);
    }

    // Проверка ролей
    public function isAdmin(): bool
    {
        return $this->role === UserRole::ADMIN;
    }

    public function isModerator(): bool
    {
        return $this->role === UserRole::MODERATOR;
    }

    public function isUser(): bool
    {
        return $this->role === UserRole::USER;
    }

    // Получение читаемого названия роли
    public function getRoleLabelAttribute(): string
    {
        return $this->role->label();
    }

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'role' => UserRole::class, // Кастинг к enum
            'status' => UserStatus::class
        ];
    }

    public function reviews()
    {
        return $this->hasMany(Review::class, 'user_id');
    }

}
