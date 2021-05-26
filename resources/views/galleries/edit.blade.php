@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        @if(session('success'))
            <span class="alert alert-success d-flex justify-content-center p-2">{{ session('success') }}</span>
        @endif
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card bg-secondary">
                    <div class="text-right mt-2 mr-2">
                        <form method="POST" action="{{ route('gallery.delete', ['gallery' => $gallery->id]) }}">
                            @csrf

                            @method('DELETE')
                            <button type="submit" class="btn btn-danger text-dark">
                                Delete
                            </button>
                        </form>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('gallery.update', ['gallery' => $gallery->id]) }}" enctype="multipart/form-data">
                            @csrf

                            @method('PUT')
                            <div class="form-group row">
                                <label for="title" class="col-md-4 col-form-label text-md-right font-weight-bold">{{ __('Title') }}</label>

                                <div class="col-md-6">
                                    <input id="title" type="text" class="form-control border-dark" name="title" value="{{ $gallery->title }}" required autofocus>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="galleries" class="col-md-4 col-form-label text-md-right font-weight-bold">{{ __('Multiple image') }}</label>
                                <div class="col-md-6">
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" name="galleries[]" id="galleries" multiple>
                                        @foreach ($errors->all() as $error)
                                            <strong class="text-danger">{{ $error }}</strong>
                                        @endforeach
                                        <label class="custom-file-label font-weight-bold" for="inputGroupFile02">Choose file</label>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row mb-0">
                                <div class="col-md-8 offset-md-4">
                                    <button type="submit" class="btn btn-dark text-danger font-weight-bold">
                                        {{ __('Edit') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="row justify-content-center mt-4">
            <div class="col-md-8">
                <div class="card bg-secondary">
                    <div class="card-header d-flex justify-content-center" style="font-size: 20px;color:black">Gallery Images</div>
                    <div class="card-body">
                        @if($gallery->images->isEmpty())
                            <h2 class = "text-secondary d-flex justify-content-center">No images in this gallery</h2>
                        @endif
                        <div class="row">
                            @foreach($gallery->images as $images)
                                <div class="col-md-6 mb-3">
                                    <div class="text-right mr-5">
                                        <form method="POST" action="{{ route('images.delete', ['images' => $images->id]) }}">
                                            @csrf

                                            @method('DELETE')
                                            <button type="submit" class="btn btn-white">
                                                <i class="far fa-trash-alt"></i>
                                            </button>
                                        </form>
                                    </div>
                                    <div class="d-flex justify-content-center">
                                        <img src="{{ asset('storage/'.$images->path) }}" alt='avatar' class = 'img-fluid rounded-circle' style = "object-fit: cover; width: 200px; height: 200px;">
                                    </div>
                                    <strong class="d-flex justify-content-center">{{ $images->original_name }}</strong>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
