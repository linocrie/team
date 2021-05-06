<?php

namespace App\Http\Controllers;

use App\Models\Profession;
use App\Models\UserProfession;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Detail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\Http\RedirectResponse;

class ProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        // Query with relationship
        // $detail  = Detail::with(['user'])->first();
        // $user->load('detail')

        // $user->detail - property lavel
        // $user->detail()->first() - query


//        $detail = Detail::with(['user'])->first();
//        $profession = UserProfession::with(['user'])->first();

        $user = Auth::user();
//        $user = User::find(1);
//
//        dd($user->professions);

//        $prof = Profession::find(1);
//
//        dd($prof->users);

        $profId = Profession::select('id')
            ->where('name', 'Business Development Manager')
            ->get();
        dd($profId);
        return view('profile')
            ->with('user', $user)
            ->with('detail', $user->detail)
            ->with('detail', $user->profession);
    }

    public function updateProfile(Request $request): RedirectResponse
    {
        $userId = Auth::id();
        $request->validate([
            'name'     => 'required|string|max:191',
            'email'    => [
                'required',
                Rule::unique('users')->ignore($userId)
            ],
            'password' => 'nullable|string',
        ]);

        User::where('id', $userId)->update([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => $request->password ? bcrypt($request->password) : Auth::user()->password
        ]);

        return back()->with('success', 'Profile successfully updated');
    }

    public function updateDetail(Request $request): RedirectResponse
    {

        Detail::updateOrCreate(
        ['user_id'    => Auth::id()],
        [
            'phone'   => $request->phone,
            'address' => $request->address,
            'city'    => $request->city,
            'country' => $request->country
        ]
        );

//        UserProfession::updateOrCreate(
//            ['user_id'       => Auth::id()],
//            ['profession_id' => ]
//        );

        return back()->with('success', 'Profile successfully updated');
    }
}
