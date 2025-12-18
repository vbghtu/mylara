<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class RegisterController extends Controller
{
    public function showRegistrationForm()
    {
        return Inertia::render('Auth/Register', [
            'layoutData' => [
                'h1' => 'Регистрация',
            ],
        ]);
    }

    public function register(RegisterRequest $request)
    {
        $user = User::create($request->validated());
        // Опционально: автоматический вход
        Auth::login($user);

        return redirect()->route('home');
    }
}

