<?php

namespace App\Enums;

enum UserStatus: string
{
    case ACTIVE = 'active';
    case INACTIVE = 'inactive';
    case SUSPENDED = 'suspended';
    case PENDING = 'pending';

    public function label(): string
    {
        return match ($this) {
            self::ACTIVE => 'Активный',
            self::INACTIVE => 'Неактивный',
            self::SUSPENDED => 'Заблокирован',
            self::PENDING => 'Ожидает подтверждения',
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::ACTIVE => 'success',
            self::INACTIVE => 'secondary',
            self::SUSPENDED => 'danger',
            self::PENDING => 'warning',
        };
    }
}
