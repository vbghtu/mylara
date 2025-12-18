<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Inertia\Inertia;

class ForgotPasswordController extends Controller
{
    public function showLinkRequestForm()
    {
        return Inertia::render('Auth/ForgotPassword');
    }

    /**
     * Отправить ссылку для сброса пароля
     */
    public function sendResetLinkEmail(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);
//@todo шаблоны  писем и отправка
        // Отправляем ссылку для сброса пароля
        $status = Password::sendResetLink(
            $request->only('email')
        );

        // Обрабатываем разные статусы ответа
        if ($status === Password::RESET_LINK_SENT) {
            return back()->with([
                'status' => __($status),
                'message_type' => 'success'
            ]);
        }

        // Если email не найден, не сообщаем об этом для безопасности
        return back()->withInput($request->only('email'))
            ->with([
                'status' => __($status),
                'message_type' => 'error'
            ]);
    }
}
