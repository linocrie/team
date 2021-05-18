@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center mb-4">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header d-flex justify-content-center">Profile</div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4 border-right">
                                <div class="d-flex justify-content-center">
                                    <img src="{{ $postUser->image ? asset('storage/'.$postUser->image->path) : asset('images/default-post.gif') }}" alt='post image' class = 'img-fluid rounded-circle' style = "object-fit: cover; width: 150px; height: 150px;">
                                </div>
                            </div>
                            <div class="col-md-8 text-secondary">
                                <p class="mb-0"><span class="text-danger">Name: </span> {{ $postUser->name }}</p>
                                <p class="mb-0"><span class="text-danger">Email: </span> {{ $postUser->email }}</p>
                                <p class="mb-0"><span class="text-danger">Phone: </span> {{ $postUser->detail->phone }}</p>
                                <p class="mb-0"><span class="text-danger">City: </span> {{ $postUser->detail->city }}</p>
                                <p class="mb-0"><span class="text-danger">Address: </span> {{ $postUser->detail->address }}</p>
                                <p class="mb-0"><span class="text-danger">Country: </span> {{ $postUser->detail->country }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
