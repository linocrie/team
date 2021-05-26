@extends('layouts.app')

@section('content')

    <div class="container">
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
                            </div>
                        </div>
                    </div>
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
