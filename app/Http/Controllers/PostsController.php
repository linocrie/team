<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostRequest;
use App\Models\Post;
use App\Models\PostProfession;
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
            ->with('user', Post::get()->where('user_id', auth()->user()->id)->load(['image']));
    }

    public function showCreate(): View
    {
        return view('createpost')
            ->with('postProfessions', PostProfession::all());
    }

    public function showEdit(Post $id): View
    {
        $postId = Post::where('id', $id->id)->where('user_id', auth()->user()->id)->first();
        abort_if(!$postId, 403, 'Unauthorized access');
        return view('editpost')
            ->with('userPost', $id)
            ->with('postProfession', PostProfession::all());
    }

    public function store(PostRequest $request): RedirectResponse
    {
        $userId = auth()->user()->id;
        $file = $request->file('image')->store('postimages');
        $lastPost = Post::Create(
            [
                'user_id'     => $userId,
                'title'       => $request->title,
                'description' => $request->description,
            ]
        );
        PostImage::Create(
            [
                'post_id'       => $lastPost->id,
                'user_id'       => $userId,
                'original_name' => $request->file('image')->getClientOriginalName(),
                'path' => $file
            ]
        );

        $lastPost->post_professions()->attach($request->postProfession);
        return redirect()->route('posts.index')->with('success', 'Post successfully created');
    }

    public function update(PostRequest $request): RedirectResponse
    {
        $postId = $request->id;
        $post = Post::where('id', $postId);
        if ($postImage = $post->first()->load(['image'])->image) {
            Storage::delete($postImage->path);
        }

        $file = $request->file('image')->store('postimages');
        $post->update(
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
        $post->where('user_id', auth()->user()->id)->first()->post_professions()->sync($request->postProfession);
        return redirect()->route('posts.index')->with('success', 'Post successfully updated');
    }

    public function delete(Request $request): RedirectResponse
    {
        $postId = $request->id;
        $post = Post::where('id', $postId);
        PostImage::where('post_id', $postId)->delete();
        $post->where('user_id', auth()->user()->id)->first()->post_professions()->detach($request->postProfession);
        $post->delete();
        return redirect()->route('posts.index')->with('success', 'Post successfully deleted');
    }
}
