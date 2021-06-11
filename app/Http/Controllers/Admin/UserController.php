<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Helpers\UsersWeather;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('is_admin');
    }

    public function index(Request $request)
    {
        $users_weather = new UsersWeather;
        $get_users_weather = $users_weather->get_weather();
        if ($request->expectsJson()) {
            $users = User::with('detail')
                ->filterUsers()
                ->searchUsers()
                ->paginate($request->perPage);

            return response()->json(['users' => $users , 'get_users_weather' => $get_users_weather->json()]);
        }
        return view('admin.users');
    }

    public function destroy(User $user)
    {
        $user->delete();
        return response()->json([]);
    }
}
