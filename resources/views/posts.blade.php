@extends('layouts.app')

@section('content')
    <div class="container">
        @foreach($user as $users)
            <a href="{{ route('posts.edit', ['id' => $users->id]) }}" class="text-decoration-none text-secondary">
                <div class="row justify-content-center mb-5">
                    <div class="col-md-8">
                        <div class="card">
                            <div class="card-header">{{ $users->title }}</div>
                            <div class="card-body">
                                <div class="row">
                                   <div class="col-md-3 border-right">
                                       <div class="d-flex justify-content-center">
                                           <img src="{{ asset('storage/'.$users->path) }}" alt='post image' class = 'img-fluid rounded-circle' style = "object-fit: cover; width: 100px; height: 100px;">
                                       </div>
                                   </div>
                                    <div class="col-md-9">
                                        {{ $users->description }}
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
