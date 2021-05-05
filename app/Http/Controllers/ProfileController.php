<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class ProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('profile');
    }

    public function updateEmail(Request $request)
    {
        if(Auth::user()->email == $request->post('oldEmail') && $request->post('newEmail') == $request->post('confirmEmail')) {
            User::where('id', Auth::user()->id)->update(array('email' => $request->post('newEmail')));
        }
        else {
            Session::flash('message', 'Wrong credentials!');
        }
        return view('profile');
    }
}
