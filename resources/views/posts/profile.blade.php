@extends('layouts.app')

@section('content')
    <div class="container">
        <p class="text-light">
            {{ $user->image  }}
        </p>
        @if(session('success'))
            <span class="alert alert-success d-flex justify-content-center p-2">{{ session('success') }}</span>
        @endif
        <div class="d-flex flex-column align-items-center">

            <div class="avatar d-flex justify-content-center align-items-center overflow-hidden rounded-circle mb-3"
                 style="width: 200px;height: 200px;background-color: rgba(0, 0, 0, 0.8);">
                <img src="{{ $user->avatar ? asset('storage/'.$user->avatar->path) : asset('images/default-post.gif') }}" alt="avatar" class="img-fluid h-100 m-3" id="userAvatar">
            </div>
            <div class="m-4 mb-5">
                <p class="font-weight-bold text-light" style="font-size: 30px">{{ $user->name }}</p>
            </div>
        </div>
        <div class="d-flex justify-content-between">
            <div class="col-md-6">
                <div class="text-center">
                    <p class="font-weight-bold text-light" style="font-size: 20px">All Information</p>
                </div>
                <div class="">
                    <p class="font-weight-bold text-light"><span style="font-size: 20px">Email:</span> {{$user->email}}</p>
                </div>
                <div>
                    <p class="font-weight-bold text-light"><span style="font-size: 20px">Phone: </span>{{$user->detail->phone}}</p>
                </div>
                <div>
                    <p class="font-weight-bold text-light"><span style="font-size: 20px">Address: </span>{{$user->detail->address}}
                    </p>
                </div>
                <div>
                    <p class="font-weight-bold text-light"><span style="font-size: 20px">City: </span>{{$user->detail->city}}</p>
                </div>
                <div>
                    <p class="font-weight-bold text-light"><span style="font-size: 20px">Country:</span> {{$user->detail->country}}
                    </p>
                </div>
                <div>
                    <p class="font-weight-bold text-light"><span
                            style="font-size: 20px">Professions:</span> {{$user->detail->professions }}</p>
                </div>
            </div>
            <div class="gallery col-md-6 text-center text-light">
                <div>
                    <p class="font-weight-bold" style="font-size: 20px">Gallery</p>
                </div>
                @if($user->galleries->isEmpty())
                    <h2 class = "text-secondary d-flex justify-content-center">No gallery available</h2>
                @endif
                <div class="d-flex flex-wrap">
                    @foreach($user->galleries as $gallery)
                        <div class="mb-3 m-3 p-2">
                            <div class="d-flex align-items-center flex-column ">
                                <div class="title d-flex">
                                    <p class="font-weight-bold text-light" style="font-size: 20px">{{$gallery->title}}</p>
                                </div>
                                <a href="{{ route('gallery.show', ['id' => $gallery->id]) }}" class="text-decoration-none text-secondary">
                                    <h3 class="text-white display-1 font-weight-bold rounded-circle d-flex justify-content-center align-items-center overflow-hidden bg-dark" style="width: 150px;height: 150px;">{{ $gallery->title[0] }} </h3>
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
@endsection

