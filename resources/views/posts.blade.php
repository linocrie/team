@extends('layouts.app')

@section('content')
    <div class="container">
        @if(!$user)
            <h2 class = "d-flex justify-content-center text-secondary">No posts created so far</h2>
        @endif
        @foreach($user as $users)
            <a href="{{ route('posts.edit', ['id' => $users->id]) }}" class="text-decoration-none text-secondary">
                <div class="row justify-content-center mb-5">
                    <div class="col-md-8">
                        <div class="card">
                            <div class="card-header">
                                <p class = "float-left mb-0">{{ $users->title }}</p>
                                <p class = "float-right mb-0">{{ $users->updated_at }}</p>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                   <div class="col-md-3 border-right">
                                       <div class="d-flex justify-content-center">
                                           <img src="{{ $users->image ? asset('storage/'.$users->image->path) : asset('images/default-post.gif') }}" alt='post image' class = 'img-fluid rounded-circle' style = "object-fit: cover; width: 100px; height: 100px;">
                                       </div>
                                   </div>
                                    <div class="col-md-9">
                                        {{ Str::limit($users->description, 250) }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        @endforeach
    </div>
@endsection
