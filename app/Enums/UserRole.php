<?php

namespace App\Enums;

enum UserRole: string
{
    case ADMIN = 'admin';
    case MODERATOR = 'moderator';
    case USER = 'user';
    case SELLER = 'seller';
    case GUEST = 'guest';

    public static function options(): array
    {
        return [
            self::ADMIN->value => self::ADMIN->label(),
            self::MODERATOR->value => self::MODERATOR->label(),
            self::USER->value => self::USER->label(),
            self::GUEST->value => self::GUEST->label(),
            self::SELLER->value => self::SELLER->label(),
        ];
    }

    public function label(): string
    {
        return match ($this) {
            self::ADMIN => 'Администратор',
            self::MODERATOR => 'Модератор',
            self::USER => 'Пользователь',
            self::GUEST => 'Гость',
            self::SELLER => 'Продавец',
        };
    }
}
