<?php

namespace App\Http\Controllers\Admin;


use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('is_admin');
    }

    public function index(Request $request)
    {
        if ($request->expectsJson()) {
            $users = User::with('detail')
                ->filterUsers()
                ->searchUsers()
                ->paginate($request->perPage);

            return $users->toJSON();
        }
        return view('admin.users');
    }

    public function destroy(User $user)
    {
        $user->delete();
        return response()->json([]);
    }
}
