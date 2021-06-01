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
                ::when($request->filter !== '', function($query) use ($request) {

                    if ($request->filter == "1") {
                        $query->whereHas('users');
                    }
                    elseif ($request->filter == "2") {
                        $query->whereHas('posts');
                    }
                    elseif($request->filter == "3") {
                        $query->has('users', '>', '5');
                    }
                    else {
                        $query->has('posts', '>', '5');
                    }

                })
                ->where('name', 'LIKE' ,'%'.$request->search.'%')
                ->paginate($request->perPage);

            return response()->json($professions);


        }

        return view('admin.professions');
    }

    public function pagination(Request $request)
    {
        if($request->ajax()) {
            return response()
                ->json(['success' => true, 'message' => Profession::where('name', 'LIKE', "%{$request->search}%")
                    ->orWhere('id', 'LIKE', "%{$request->search}%")
                    ->orWhere('created_at', 'LIKE', "%{$request->search}%")
                    ->orWhere('updated_at', 'LIKE', "%{$request->search}%")
                    ->simplePaginate(5)]);
        }
    }

    public function search(Request $request): JsonResponse
    {
        $professions = Profession::where('name', 'LIKE', "%{$request->search}%")
            ->orWhere('id', 'LIKE', "%{$request->search}%")
            ->orWhere('created_at', 'LIKE', "%{$request->search}%")
            ->orWhere('updated_at', 'LIKE', "%{$request->search}%")
            ->simplePaginate(5);

        return response()
                ->json(['success' => true, 'message' => $professions]);
    }

    public function filter(Request $request): JsonResponse
    {
        if($request->filter) {
            if ($request->filter == "1") {
                $professions = Profession::whereHas('users')->simplePaginate(5);
            }
            elseif ($request->filter == "2") {
                $professions = Profession::whereHas('posts')->simplePaginate(5);
            }
            elseif($request->filter == "3") {
                $professions = Profession::has('users', '>', '5')->simplePaginate(5);
            }
            else {
                $professions = Profession::has('posts', '>', '5')->simplePaginate(5);
            }
            return response()
                ->json(['success' => true, 'message' => $professions]);
        }
        else {
            return response()
                ->json(['success' => true, 'message' => Profession::simplePaginate(5)]);
        }
    }

    public function destroy(Profession $profession): RedirectResponse
    {
        // onDelete cascade in migrations
        $profession->delete();

        return back()
            ->with('success', 'Profession successfully deleted');
    }
}
