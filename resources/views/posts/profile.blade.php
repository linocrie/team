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
                                    <img src="{{ $user->image ? asset('storage/'.$user->image->path) : asset('images/default-post.gif') }}" alt='post image' class = 'img-fluid rounded-circle' style = "object-fit: cover; width: 150px; height: 150px;">
                                </div>
                            </div>
                            <div class="col-md-8 text-secondary">
                                <p class="mb-0"><span class="text-danger">Name: </span> {{ $user->name }}</p>
                                <p class="mb-0"><span class="text-danger">Email: </span> {{ $user->email }}</p>
                                <p class="mb-0"><span class="text-danger">Phone: </span> {{ $user->detail->phone }}</p>
                                <p class="mb-0"><span class="text-danger">City: </span> {{ $user->detail->city }}</p>
                                <p class="mb-0"><span class="text-danger">Address: </span> {{ $user->detail->address }}</p>
                                <p class="mb-0"><span class="text-danger">Country: </span> {{ $user->detail->country }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row justify-content-center mb-4">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header d-flex justify-content-center">Galleries</div>
                    <div class="card-body">
                        @if($user->galleries->isEmpty())
                            <h2 class = "text-secondary d-flex justify-content-center">No gallery available</h2>
                        @endif
                        <div class="row">
                            @foreach($user->galleries as $gallery)
                                <div class="col-md-6">
                                    <div class="d-flex justify-content-center">
                                        <a href="{{ route('gallery.show', ['id' => $gallery->id]) }}" class="text-decoration-none text-secondary">
                                            <h3 class="text-white display-1 font-weight-bold rounded-circle d-flex justify-content-center align-items-center overflow-hidden bg-dark" style="width: 200px;height: 200px;">{{ $gallery->title[0] }} </h3>
                                        </a>
                                    </div>
                                    <strong class="d-flex justify-content-center">{{ $gallery->title }}</strong>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
