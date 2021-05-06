<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Detail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index() {
        return view('profile')->with('user', Auth::user());
    }

    public function update(Request $request) {

        if($request->get('form') == 1) {
            $request->validate([
                'name' => 'required|string|max:191',
                'email' => [
                    'required',
                    Rule::unique('users')->ignore(Auth::id())
                ],
                'password' => 'nullable|string',
            ]);

            User::where('id', Auth::id())->update([
                'name' => $request->name,
                'email' => $request->email,
                'password' => $request->password ? bcrypt($request->password) : Auth::user()->password
            ]);
        }
        else if($request->get('form') == 2) {
            $request->validate([
                'phone' => Rule::unique('details')->ignore(Auth::id())
            ]);

            Detail::where('id', Auth::id())->update([
                'phone' => $request->phone,
                'address' => $request->address,
                'city' => $request->city,
                'country' => $request->country
            ]);
        }

        return back()->with('success', 'Profile successfully updated');
    }
}
