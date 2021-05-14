<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostRequest;
use App\Models\Post;
use App\Models\PostImage;
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
            ->with('user', Post::select('id', 'title', 'description')->where('user_id', auth()->user()->id)->get()->load(['image']));
    }

    public function show(Post $id): View
    {
        $postId = Post::where('id', $id->id)->where('user_id', auth()->user()->id)->first();
        abort_if(!$postId, 403, 'Unauthorized access');
        return view('editpost')
            ->with('userPost', $id);
    }

    public function store(PostRequest $request): RedirectResponse
    {
        $file = $request->file('image')->store('postimages');
        Post::Create(
            [
                'user_id'     => auth()->user()->id,
                'title'       => $request->title,
                'description' => $request->description,
            ]
        );
        PostImage::Create(
            [
                'post_id'       => Post::where('user_id', auth()->user()->id)->select('id')->orderBy('id', 'DESC')->first()->id,
                'user_id'       => auth()->user()->id,
                'original_name' => $request->file('image')->getClientOriginalName(),
                'path' => $file
            ]
        );
        return redirect()->route('posts.index');
    }

    public function update(PostRequest $request): RedirectResponse
    {
        $postId = $request->id;
        if ($postImage = Post::where('id', $postId)->first()->load(['image'])->image) {
            Storage::delete($postImage->path);
        }

        $file = $request->file('image')->store('postimages');
        Post::where('id', $postId)->update(
            [
                'title'       => $request->title,
                'description' => $request->description
            ]
        );
        PostImage::where('post_id', $postId)->update(
            [
                'original_name' => $request->file('image')->getClientOriginalName(),
                'path'          => $file
            ]
        );
        return redirect()->route('posts.index');
    }

    public function delete(Request $request): RedirectResponse
    {
        PostImage::where('post_id', $request->id)->delete();
        Post::where('id', $request->id)->delete();
        return redirect()->route('posts.index');
    }
}
