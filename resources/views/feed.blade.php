@extends('layouts.app')

@section('content')
<div class="container">
    @if(!$postsProfession->first())
        <h2 class = "d-flex justify-content-center text-secondary">No posts matches your profession</h2>
    @endif
    @foreach($postsProfession as $posts)
        <a href="{{ route('posts.detail', ['post' => $posts->id]) }}" class="text-decoration-none text-secondary">
            <div class="row justify-content-center mb-4">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">
                            <p class = "float-left mb-0">{{ $posts->title }}</p>
                            <p class = "float-right mb-0">{{ Str::substr($posts->updated_at, 0, 16) }}</p>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-3 border-right">
                                    <div class="d-flex justify-content-center">
                                        <img src="{{ $posts->image ? asset('storage/'.$posts->image->path) : asset('images/default-post.gif') }}" alt='post image' class = 'img-fluid rounded-circle' style = "object-fit: cover; width: 100px; height: 100px;">
                                    </div>
                                </div>
                                <div class="col-md-9">
                                    {{ Str::limit($posts->description, 250) }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </a>
    @endforeach
    <div class="d-flex justify-content-center text-decoration-none">
        {{ $postsProfession->links() }}
    </div>
</div>
@endsection
