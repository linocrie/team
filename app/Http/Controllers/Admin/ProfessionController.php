<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Profession;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\JsonResponse;

class ProfessionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
//        $this->middleware('is_admin');
    }

    public function index(Request $request)
    {

        if ($request->expectsJson()) {
            $professions = Profession
                ::filterByRelation()
                ->searchName()
                ->paginate($request->perPage);

            return response()->json($professions);

        }

        return view('admin.professions');
    }

    public function destroy(Profession $profession)
    {
        // onDelete cascade in migrations
        $profession->delete();
        return response()->json([]);
    }
}
