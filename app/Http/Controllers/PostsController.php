<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostRequest;
use App\Mail\PostCreated;
use App\Models\Post;
use App\Models\Profession;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Mail;
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
        $posts = Post::with(['image'])->authorize()->get();

        return view('posts.posts')
            ->with('posts', $posts);
    }

    public function create(): View
    {
        return view('posts.create')
            ->with('professions', Profession::all());
    }

    public function edit(Post $post): View
    {
        abort_if($post->user_id !== auth()->id(), 403, "Unauthorized access");

        return view('posts.edit')
            ->with('post', $post)
            ->with('professions', Profession::all());
    }

    public function show(Post $post): View
    {
        return view('posts.show')
            ->with('post', $post->load(['user', 'professions']));
    }

    public function profile(User $user): View
    {
        return view('posts.profile')
            ->with('user', $user->load(['avatar', 'detail', 'galleries', 'professions']));
    }

    public function store(PostRequest $request): RedirectResponse
    {
        $file = $request->file('image')->store('postimages');

        $post = Post::create([
            'user_id'     => auth()->id(),
            'title'       => $request->title,
            'description' => $request->description,
        ]);

        $post->image()->create([
            'original_name' => $request->file('image')->getClientOriginalName(),
            'path'          => $file
        ]);

        $post->professions()->sync($request->postProfession);

        Mail::to(auth()->user())->send(new PostCreated($post));

        return redirect()
            ->route('posts.index')
            ->with('success', 'Post successfully created');
    }

    public function update(Request $request, Post $post): RedirectResponse
    {
        abort_if($post->user_id !== auth()->id(), 403, "Unauthorized access");

        $request->validate([
            'title'       => 'required|string|max:191',
            'description' => 'required|string',
            'image'       => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $post->update(
            [
                'title' => $request->title,
                'description' => $request->description
            ]
        );

        if($request->hasFile('image')) {
            if ($post->image()->exists()) {
                if(Storage::exists($path = $post->image->path)) {
                    Storage::delete($path);
                }
            }

            $path = $request->file('image')->store('postimages');

            $post->image()->updateOrCreate(
                ['post_id'          => $post->id],
                [
                    'original_name' => $request->file('image')->getClientOriginalName(),
                    'path'          => $path
                ]
            );
        }

        $post->professions()->sync($request->postProfession);

        return redirect()
            ->route('posts.index')
            ->with('success', 'Post successfully updated');
    }

    public function delete(Post $post): RedirectResponse
    {
        abort_if($post->user_id !== auth()->id(), 403, "Unauthorized access");

        if ($post->image()->exists()) {
            if(Storage::exists($path = $post->image->path)) {
                Storage::delete($path);
            }
            $post->image()->delete();
        }

        $post->professions()->detach();
        $post->delete();

        return redirect()
            ->route('posts.index')
            ->with('success', 'Post successfully deleted');
    }
}
