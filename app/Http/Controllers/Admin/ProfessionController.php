<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Profession;
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
        return view('admin.professions')
            ->with('filterProfessions', Profession::all())
            ->with('professions', Profession::simplePaginate(5));
    }

    public function search(Request $request): JsonResponse
    {
        $professions = Profession::where('name', 'LIKE', "%{$request->txt}%")
            ->orWhere('id', 'LIKE', "%{$request->txt}%")
            ->orWhere('created_at', 'LIKE', "%{$request->txt}%")
            ->orWhere('updated_at', 'LIKE', "%{$request->txt}%")
            ->get();
        if(!$professions->isEmpty()) {
            return response()
                ->json(['success' => true, 'message' => $professions]);
        }
        else {
            return response()
                ->json(['success' => false, 'message' => "No professions found"]);
        }
    }

    public function filter(Request $request): JsonResponse
    {
        if(!$request->profession) {
            return response()
                ->json(['success' => true, 'message' => Profession::all()]);
        }
        else {
            $professions = Profession::whereIn('id', $request->profession)
                ->get();
            return response()
                ->json(['success' => true, 'message' => $professions]);
        }
    }

    public function destroy(Profession $profession): RedirectResponse
    {
        if($profession->posts()->exists()) {
            $profession->posts()->detach();
        }

        if($profession->users()->exists()) {
            $profession->users()->detach();
        }

        $profession->delete();

        return back()
            ->with('success', 'Profession successfully deleted');
    }
}
