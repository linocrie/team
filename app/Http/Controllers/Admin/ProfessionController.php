<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Profession;
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

    public function index(): View
    {
//        dd(Profession::simplePaginate(5));
        return view('admin.professions')
            ->with('professions', Profession::simplePaginate(5));
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

    public function search(Request $request)
    {

        $professions = Profession::where('name', 'LIKE', "%{$request->search}%")
            ->orWhere('id', 'LIKE', "%{$request->search}%")
            ->orWhere('created_at', 'LIKE', "%{$request->search}%")
            ->orWhere('updated_at', 'LIKE', "%{$request->search}%")
            ->simplePaginate(5);

//        if (!$professions->isEmpty()) {
//            return response()
//                ->json(['success' => true, 'message' => $professions]);
//        }

//        if (!$professions->isEmpty()) {
            return view('admin.professions')
                ->with('professions', $professions);
//        }
//        else {
//            return view('admin.professions')
//                ->with('professions', "$professions");
//        }
    }

    public function filter(Request $request)
    {
        $options = collect($request->profession);
        if($options->isEmpty()) {
            return back()
                ->with('professions', Profession::simplePaginate(5));
        }
        else {
            if ($options->count() == 1) {
                if ($options->contains("1")) {
                    return response()
                        ->json(['success' => true, 'message' => Profession::whereHas('users')->get()]);
                } else {
                    return response()
                        ->json(['success' => true, 'message' => Profession::whereHas('posts')->get()]);
                }
            } elseif ($options->count() == 2) {
                return response()
                    ->json(['success' => true, 'message' => Profession::whereHas('posts')->whereHas('users')->get()]);
            } else {
                return view('admin.professions')
                    ->with('professions', Profession::simplePaginate(5));
            }
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
