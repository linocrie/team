<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\PostsWeather;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Post;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('is_admin');
    }

    public function index(Request $request)
    {
        $postsWeather = new PostsWeather();
        $weatherData = $postsWeather->get_weather();
        if ($request->expectsJson()) {
            $posts = Post::with('professions')
                ->filterPosts()
                ->searchPosts()
                ->paginate($request->perPage);

            return response()->json(['posts' => $posts, 'weather' => $weatherData->json()]);
        }

        return view('admin.posts');
    }

    public function destroy(Post $post)
    {
        if ($postImage = $post->image()->first()) {
            if(Storage::exists($path = $postImage->path)) {
                Storage::delete($path);
            }
            $post->image()->delete();
        }

        $post->professions()->detach();
        $post->delete();

        return response()->json([]);
    }
}
