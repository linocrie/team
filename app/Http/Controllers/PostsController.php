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
        return view('posts')
            ->with('user', Post::where('user_id', auth()->user()->id)->get()->load(['image']));
    }

    public function create(): View
    {
        return view('createpost')
            ->with('postProfessions', Profession::all());
    }

    public function edit(Post $post): View
    {
        abort_if($post->user_id !== auth()->user()->id, 403, 'Unauthorized access');
        return view('editpost')
            ->with('userPost', $post)
            ->with('postProfession', Profession::all());
    }

    public function detail(Post $post): View
    {
        $postsProfession = Post::where('user_id', '!=', auth()->user()->id)->whereHas('professions', function (Builder $query) {
            $query->whereIn('profession_id', auth()->user()->professions->pluck('id'));
        })->pluck('id');
        abort_if(!$postsProfession->contains($post->id), 403, 'Unauthorized access');
        return view('detailpost')
            ->with('postDetail', $post)
            ->with('author', $post->user()->first());
    }

    public function profile(User $user): View
    {
        return view('postuserprofile')
            ->with('postUser', $user->load(['avatar', 'detail']));
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
        $lastPost->professions()->attach($request->postProfession);

        return redirect()->route('posts.index')
            ->with('success', 'Post successfully created');
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

        // updateOrCreate for testing seeders, without seeders only update needed
        PostImage::where('post_id', $postId)->updateOrCreate(
            ['post_id'          => $postId],
            [
                'original_name' => $request->file('image')->getClientOriginalName(),
                'path'          => $file
            ]
        );
        $post->where('user_id', auth()->user()->id)->first()->professions()->sync($request->postProfession);

        return redirect()->route('posts.index')
            ->with('success', 'Post successfully updated');
    }

    public function delete(Request $request): RedirectResponse
    {
        $postId = $request->id;
        $post = Post::where('id', $postId);
        $postImage = PostImage::where('post_id', $postId);
        Storage::delete($postImage->first()->path);
        $postImage->delete();
        $post->where('user_id', auth()->user()->id)->first()->professions()->detach($request->postProfession);
        $post->delete();

        return redirect()->route('posts.index')
            ->with('success', 'Post successfully deleted');
    }
}
