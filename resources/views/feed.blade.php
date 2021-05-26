@extends('layouts.app')

@section('content')
<div class="container">
    @if($posts->isEmpty())
        <h2 class = "d-flex justify-content-center text-secondary">No posts matches your profession</h2>
    @endif
    @foreach($posts as $post)
        <a href="{{ route('posts.detail', ['post' => $post->id]) }}" class="text-decoration-none text-dark">
            <div class="row d-flex justify-content-center">
                <div class="card bg-secondary mb-3">
                    <div class="d-flex">
                        <div class="avatar overflow-hidden rounded-circle m-4"
                             style="width: 100px;height: 100px;background-color: rgba(0, 0, 0, 0.8);">
                            <img
                                src="{{ $post->image ? asset('storage/'.$post->image->path) : asset('images/default-post.gif') }}"
                                alt="avatar" class="img-fluid h-100" id="image" style="object-fit: cover;">
                        </div>
                        <div class="post m-4" style="width: 500px;">
                            <div class="post-side">
                                <div class="font-weight-bold">
                                    <h2>{{$post->title}}</h2>
                                </div>
                                <div>
                                    <p class="font-weight-bold">Updated: {{substr($post->updated_at, 0, 16)}}</p>
                                </div>
                                <div>
                                    <p>{{Str::limit($post->description),250}}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </a>
    @endforeach
    <div class="d-flex justify-content-center text-decoration-none">
        {{ $posts->links() }}
    </div>
</div>
@endsection
