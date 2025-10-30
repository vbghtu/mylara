<?php

namespace Database\Seeders;

use App\Enums\UserRole;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Главный Администратор',
            'email' => 'admin@mylara.com',
            'password' => Hash::make('password123'),
            'role' => UserRole::ADMIN,
        ]);

        User::create([
            'name' => 'Модератор Иван',
            'email' => 'moderator@mylara.com',
            'password' => Hash::make('password123'),
            'role' => UserRole::MODERATOR,
        ]);

//        User::create([
//            'name' => 'Гость Павел',
//            'email' => 'guest@mylara.com',
//            'password' => Hash::make('password123'),
//            'role' => UserRole::GUEST,
//        ]);

        User::create([
            'name' => 'Продавец Ашот',
            'email' => 'seller@mylara.com',
            'password' => Hash::make('password123'),
            'role' => UserRole::SELLER,
        ]);
    }
}
