
@extends('layouts.app')

@section('content')
    <div class="container">
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
        </div>
    </div>
@endsection
