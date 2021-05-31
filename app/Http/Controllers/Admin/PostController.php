<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;

class PostController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('is_admin');
    }

    public function  index() {
        return view('admin.posts')
            ->with('posts', Post::with('user', 'professions')->paginate(10));
    }
}
