<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileRequest;
use App\Models\Profession;
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
        return view('profile')
            ->with('user', auth()->user()->load(['professions', 'detail', 'avatar', 'galleries']))
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
