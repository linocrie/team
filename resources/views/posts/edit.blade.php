@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card bg-secondary">
                    <div class="text-right mr-2 mt-2">
                        <form method="POST" action="{{ route('posts.delete', ['post' => $post->id]) }}">
                            @csrf

                            @method('DELETE')
                            <button type="submit" class="btn btn-danger p-1 ">
                                <i class="far fa-trash-alt text-dark"></i>
                            </button>
                        </form>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('posts.update', ['post' => $post->id]) }}" enctype="multipart/form-data">
                            @csrf

                            @method('PUT')
                            <div class="form-group row">
                                <label for="title" class="col-md-4 col-form-label text-md-right font-weight-bold">{{ __('Title') }}</label>

                                <div class="col-md-6">
                                    <input id="title" type="text" class="form-control border-dark" name="title" value="{{ $post->title }}" required autofocus>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="description" class="col-md-4 col-form-label text-md-right font-weight-bold">{{ __('Description') }}</label>

                                <div class="col-md-6">
                                    <textarea class="form-control border-dark" id="textarea" name="description" rows="3" required autofocus>{{ $post->description }}</textarea>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="pProfession" class="col-md-4 col-form-label text-md-right font-weight-bold">{{ __('Profession') }}</label>
                                <div class="col-md-6">
                                    <select name="postProfession[]" multiple="multiple" id="multiSelect">
                                        @foreach ($professions as $profession)
                                        <option value="{{ $profession->id }}" @if($post->professions->contains($profession->id)) selected @endif>{{ $profession->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="pImage" class="col-md-4 col-form-label text-md-right font-weight-bold">{{ __('Image') }}</label>
                                <div class="col-md-6">
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input border-dark @error('image') is-invalid @enderror" name="image" id="image">

                                        @error('image')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                        <label class="custom-file-label font-weight-bold" for="inputGroupFile02">Choose file</label>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row mb-0">
                                <div class="col-md-8 offset-md-4">
                                    <button type="submit" class="btn btn-dark font-weight-bold text-danger">
                                        {{ __('Edit') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
