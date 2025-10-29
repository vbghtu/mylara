<?php

namespace App\Http\Controllers;

use App\Models\User;

class MainController extends Controller
{
    public function index()
    {
        $users = User::with('profile')->get();

        return view('welcome', compact('users'));
    }
}
