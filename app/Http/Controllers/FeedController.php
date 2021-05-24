<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Scopes\PostUser;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\View\View;

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
    public function index(): View
    {
        $posts = Post::where('user_id', '!=', auth()->id())->whereHas('professions', function (Builder $query) {
            $query->whereIn('profession_id', auth()->user()->professions->pluck('id'));
        })->simplePaginate(5);
        return view('feed')
            ->with('posts', $posts);
    }
}
