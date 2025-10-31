<?php

namespace App\Http\Controllers;

use Inertia\Inertia;

class MainController extends Controller
{
    public function index()
    {
//        $user = $user->get();
        $user = auth()->user();
//        dump($user);
        return Inertia::render('Main/Index', [
            'user' => $user,
            'layoutData' => [
                'h1' => 'Главная',
            ],
        ]);
//        return view('welcome', compact('users'));
    }
}
