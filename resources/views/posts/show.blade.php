
@extends('layouts.app')

@section('content')
    <div class="container">
<<<<<<< HEAD
        <div class="row">
            <div class="card mb-3 bg-secondary">
                <div class="card-header border-dark">
                    <a href="{{ route('posts.profile', ['user' => $post->user->id]) }}" class="text-decoration-none" style="color:black">
                        <p class="font-weight-bold">Post Creator: {{$post->user->name}}</p>
                    </a>
                </div>
                <div class="card-body d-flex">
                    <div class="avatar overflow-hidden rounded-circle m-4"
                         style="width: 150px;height: 150px;background-color: rgba(0, 0, 0, 0.8);">
                        <img
                            src="{{ $post->image ? asset('storage/'.$post->image->path) : asset('images/default-post.gif') }}"
                            alt="avatar" class="img-fluid h-100" id="userAvatar" style="object-fit: cover;">
                    </div>
                    <div class="post m-4 col-md-9">
                        <div class="post-side">
                            <div class="font-weight-bold">
                                <h2 style="color:black">{{$post->title}}</h2>
                            </div>
                            <div>
                                <p class="font-weight-bold" style="color:black">Updated: {{substr($post->updated_at, 11, -3)}}</p>
                            </div>
                            <div>
                                <p class="font-weight-bold mr-2" style="color:black">Description:</p>
                                <p style="color:black">{{$post->description}}</p>
=======
        <div class="row justify-content-center mb-4">
            <div class="col-md-8">
                <a href="{{ route('posts.profile', ['user' => $post->user->id]) }}" class="text-decoration-none text-secondary">
                    Author: {{ $post->user->name }}
                </a>
                <div class="card">
                    <div class="card-header">
                        <p class = "float-left mb-0">{{ $post->title }}</p>
                        <p class = "float-right mb-0">{{ Str::substr($post->updated_at, 0, 16) }}</p>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-3 border-right">
                                <div class="d-flex justify-content-center">
                                    <img src="{{ $post->image ? asset('storage/'.$post->image->path) : asset('images/default-post.gif') }}" alt='post image' class = 'img-fluid rounded-circle' style = "object-fit: cover; width: 100px; height: 100px;">
                                </div>
                            </div>
                            <div class="col-md-9">
                                {{ $post->description }}
>>>>>>> df7a37cf86ffe56ad33131822d25c9c2bb9ffb5f
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mt-3">
                    @foreach($post->professions as $profession)
                        <span class="p-1 bg-secondary text-white mr-2 rounded">#{{ $profession->name }}</span>
                    @endforeach
                </div>
            </div>
            <div class="mt-2">
                @foreach($post->professions as $profession)
                    <span style="color:black" class="p-1 bg-secondary text-black mr-2 rounded">#{{ $profession->name }}</span>
                @endforeach
            </div>
        </div>
    </div>
@endsection
