<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class MainController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        return Inertia::render('Main/Index', [
            'user' => $user,
            'layoutData' => [
                'h1' => 'Главная',
            ],
        ]);
//        return view('welcome', compact('users'));
    }
}
