<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileRequest;
use App\Jobs\ThumbnailGenerator;
use App\Models\Profession;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');

    }

    public function index(): View
    {
        $user = auth()->user()->load(['professions', 'detail', 'avatar', 'galleries']);

        return view('profile')
            ->with('user', $user)
            ->with('professions', Profession::all());
    }

    public function update(ProfileRequest $request): RedirectResponse
    {
        $user = auth()->user();
        $user->update([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => $request->password ? bcrypt($request->password) : $user->password
        ]);

        return back()
            ->with('success', 'Profile successfully updated');
    }
}
