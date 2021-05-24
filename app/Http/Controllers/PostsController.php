<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostRequest;
use App\Models\Post;
use App\Models\Profession;
use App\Models\PostImage;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
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
        $posts = Post::with(['image'])->get();

        return view('posts')->with('posts', $posts);
    }

    public function create(): View
    {
        return view('posts.create')
            ->with('professions', Profession::all());
    }

    public function edit(Post $post): View
    {
        return view('editpost')
            ->with('post', $post)
            ->with('professions', Profession::all());
    }

    public function show(Post $post): View
    {
        return view('show')
            ->with('post', $post->load('user'));
    }

    public function profile(User $user): View
    {
        return view('postuserprofile')
            ->with('postUser', $user->load(['avatar', 'detail', 'galleries']));
    }

    public function store(PostRequest $request): RedirectResponse
    {
        $userId = auth()->id();
        $file = $request->file('image')->store('postimages');

        $post = Post::create([
            'user_id'     => $userId,
            'title'       => $request->title,
            'description' => $request->description,
        ]);

        $post->image()->create([
            'user_id'       => $userId,
            'original_name' => $request->file('image')->getClientOriginalName(),
            'path'          => $file
        ]);

        $post->professions()->attach($request->postProfession);

        return redirect()->route('posts.index')->with('success', 'Post successfully created');
    }

    public function update(PostRequest $request, Post $post): RedirectResponse
    {
        if ($post->image()->exists()) {
            Storage::delete($post->image->path);
        }

        $file = $request->file('image')->store('postimages');

        $post->update([
            'title'       => $request->title,
            'description' => $request->description
        ]);

        PostImage::updateOrCreate(
            ['post_id' => $post->id],
            [
                'original_name' => $request->file('image')->getClientOriginalName(),
                'path'          => $file
            ]
        );

        $post->professions()->sync($request->professions);

        return redirect()
            ->route('posts.index')
            ->with('success', 'Post successfully updated');
    }

    public function delete(Post $post): RedirectResponse
    {
        if ($post->image()->exists()) {
            Storage::delete($post->image->path);

            $post->image()->delete();
        }

        $post->professions()->detach();
        $post->delete();

        return redirect()->route('posts.index')
            ->with('success', 'Post successfully deleted');
    }
}
