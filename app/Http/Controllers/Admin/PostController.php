<?php

namespace App\Http\Controllers\Admin;

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

    public function  index(Request $request)
    {
        if ($request->expectsJson()) {
            $posts = Post::with('professions')
                ->filterPosts()
                ->searchPosts()
                ->paginate($request->perPage);

            return $posts->toJSON();
        }

        return view('admin.posts');
    }

    public function delete(Post $postId)
    {
        if ($postImage = $postId->image()->first()) {
            if(Storage::exists($path = $postImage->path)) {
                Storage::delete($path);
            }
            $postId->image()->delete();
        }

        $postId->professions()->detach();
        $postId->delete();

        return response()->json([]);
    }
}
