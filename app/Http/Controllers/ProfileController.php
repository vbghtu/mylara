<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;
use Inertia\Response as InertiaResponse;

class ProfileController extends Controller
{

    public function show(Request $request): InertiaResponse
    {
        $user = Auth::user();
        return Inertia::render('Profile/Index', [
            'user' => $user,
            'layoutData' => [
                'h1' => 'Профиль',
            ],
        ]);
    }

    public function store(UserRequest $request): RedirectResponse
    {
        $user = Auth::user();
        $data = [];

        if ($request->filled('email')) {
            $data['email'] = $request->email;
        }

        if ($request->filled('name')) {
            $data['name'] = $request->name;
        }

        if ($request->hasFile('photo')) {
            if ($user->profile_photo) {
                Storage::disk('public')->delete($user->profile_photo);
            }

            $data['profile_photo'] = $request->file('photo')->store('profile-photos', 'public');
        }

        if (!empty($data)) {
            $user->update($data);
        }
//        return redirect()->route('profile.show', ['user' => $user])->with('success', 'Фото профиля обновлено!');
        return back()->with('success', 'Профиль обновлён!');

    }
}
