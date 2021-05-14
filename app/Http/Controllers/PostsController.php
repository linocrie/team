<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostRequest;
use App\Models\Post;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class PostsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(): View
    {
        return view('posts')
            ->with('user', auth()->user()->load(['posts'])->posts->all());
    }

    public function store(PostRequest $request): RedirectResponse
    {
        $file = $request->file('image')->store('postimages');
        Post::Create(
            [
                'user_id'    => auth()->user()->id,
                'title'   => $request->title,
                'description' => $request->description,
                'original_name' => $request->file('image')->getClientOriginalName(),
                'path'    => $file
            ]
        );
        return redirect()->route('posts.index');
    }

    public function update(PostRequest $request): RedirectResponse
    {
        $user = auth()->user();
        $postId = $request->id;

        if ($user->load(['posts'])->posts) {
            Storage::delete(Post::select('path')->where('id', $postId)->first()->path);
        }

        $file = $request->file('image')->store('postimages');
        Post::where('id', $postId)->update(
            [
                'title'   => $request->title,
                'description' => $request->description,
                'original_name' => $request->file('image')->getClientOriginalName(),
                'path'    => $file
            ]
        );
        return redirect()->route('posts.index');
    }

    public function delete(Request $request): RedirectResponse
    {
        Post::where('id', $request->id)->delete();
        return redirect()->route('posts.index');
    }
}
