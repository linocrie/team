@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row">
            <div class="card border mb-3">
                <div class="card-header">
                    <a href="{{ route('posts.profile', ['user' => $post->user->id]) }}" class="text-decoration-none text-dark">
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
                                <h2>{{$post->title}}</h2>
                            </div>
                            <div>
                                <p class="font-weight-bold">Updated: {{substr($post->updated_at, 11, -3)}}</p>
                            </div>
                            <div>
                                <p class="font-weight-bold mr-2">Description:</p>
                                <p>{{$post->description}}</p>
                            </div>
                            <div class="d-flex flex-wrap">
                                <p class="font-weight-bold mr-2">Professions: </p>
                                @foreach($post->professions as $profession)
                                    <p class="mr-3">{{$profession->name}}</p>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
