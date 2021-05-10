<?php

namespace App\Http\Controllers;

use App\Models\Profession;
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

        $user_prof = User::with(['professions'])->find(Auth::id());
        $arr = [];
        foreach ($user_prof->professions as $userProf) {
            array_push($arr, $userProf->id);
        }
        $profession = Profession::select('name', 'id')->get();
        $user = User::with(['detail'])->find(Auth::id());

        return view('profile')
            ->with('user', $user)
            ->with('profession', $profession)
            ->with('user_profession', $arr);
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

        return back()
            ->with('success', 'Profile successfully updated');
    }

    public function updateDetail(Request $request): RedirectResponse
    {

        $request->validate([
            'phone'       => 'required',
            'address'     => 'required|string|max:191',
            'city'        => 'required|string|max:191',
            'country'     => 'required|string|max:191'
        ]);

        Detail::updateOrCreate(
        ['user_id'    => Auth::id()],
        [
            'phone'   => $request->phone,
            'address' => $request->address,
            'city'    => $request->city,
            'country' => $request->country
        ]
        );

//        $prof = Profession::get()->pluck('id');
        $prof = $request->profession;
        $user = Auth::user();
        $user->professions()->sync($prof);

        return back()
            ->with('success', 'Profile successfully updated');
    }

    public function upload(Request $request): RedirectResponse
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $imageName = time().'.'.$request->image->extension();
        $request->image->move(public_path('images/avatars'), $imageName);

        Detail::updateOrCreate(
            ['user_id'    => Auth::id()],
            [
                'avatar'  => $imageName
            ]
        );

        return back()
            ->with('success','Image successfully uploaded');
    }
}
