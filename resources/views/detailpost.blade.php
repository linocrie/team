@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center mb-4">
            <div class="col-md-8">
                <a href="{{ route('posts.profile', ['user' => $author->id]) }}" class="text-decoration-none text-secondary">
                    Author: {{ $author->name }}
                </a>
                <div class="card">
                    <div class="card-header">
                        <p class = "float-left mb-0">{{ $postDetail->title }}</p>
                        <p class = "float-right mb-0">{{ Str::substr($postDetail->updated_at, 0, 10) }}</p>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-3 border-right">
                                <div class="d-flex justify-content-center">
                                    <img src="{{ $postDetail->image ? asset('storage/'.$postDetail->image->path) : asset('images/default-post.gif') }}" alt='post image' class = 'img-fluid rounded-circle' style = "object-fit: cover; width: 100px; height: 100px;">
                                </div>
                            </div>
                            <div class="col-md-9">
                                {{ $postDetail->description }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
