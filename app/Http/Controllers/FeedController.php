<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Database\Eloquent\Builder;

class FeedController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $postsProfession = Post::whereHas('professions', function (Builder $query) {
            $userProfession = auth()->user()->load(['professions'])->professions;
            $arr = [];
            foreach ($userProfession as $professions) {
                array_push($arr, $professions->id);
            }
            $query->whereIn('profession_id', $arr);
        })->simplePaginate(5);
        return view('feed')
            ->with('postsProfession', $postsProfession);
    }
}
