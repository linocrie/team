<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('profile')->with('user', Auth::user());
    }

    public function update(Request $request)
    {

        $request->validate([
            'name'     => 'required|string|max:191',
            'email'    => [
                'required',
                Rule::unique('users')->ignore(Auth::id())
            ],
            'password' => 'nullable|string',
        ]);

        User::where('id', Auth::id())->update([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => $request->password ? bcrypt($request->password) : Auth::user()->password
        ]);

        return back()->with('success', 'Profile successfully updated');
    }
}
