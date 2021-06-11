@extends('layouts.app')
@section("navbar")
    <li class="nav-item">
        <a class="nav-link text-danger font-weight-bold" href="{{ route('gallery.create') }}" role="button" aria-haspopup="true" aria-expanded="false" v-pre>
            {{ __('Create gallery') }}
        </a>
    </li>
@endsection
@section('content')
    <div class="container-fluid">
        @if(session('success'))
            <span class="alert alert-success d-flex justify-content-center p-2">{{ session('success') }}</span>
        @endif
        <div class="row">
            <div class="col-md-3">
                <div class="d-flex justify-content-center">
                    <img src="{{ $user->avatar ? asset('storage/avatars/'.pathinfo($user->avatar->path, PATHINFO_FILENAME)).'_thumbnail.'.pathinfo($user->avatar->path, PATHINFO_EXTENSION) :  asset('images/default-avatar.png') }}" alt='avatar' class = 'rounded-circle'>
                </div>
                <div class="w-75 m-auto">
                    <form action="{{ route('profile.upload') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                        <div class="custom-file mt-1">
                            <input type="file" class="custom-file-input @error('image') is-invalid @enderror"  name="image" id="imageName">

                            @error('image')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                            <label class="custom-file-label font-weight-bold" for="inputGroupFile02">Choose file</label>
                        </div>
                        <button id = "uploadButton" type="submit" class="btn btn-light text-danger font-weight-bold w-100 mt-1" disabled>Upload</button>
                    </form>
                </div>
            </div>

            <div class="col-md-8">
                <div class="card bg-secondary mb-5">
                    <div class="card-header font-weight-bold" style="font-size: 20px">Hello {{ Auth::user()->name }}</div>

                    <div class="card-body">

                        <form method="POST" action="{{ route('profile.update.profile') }}">
                            @csrf

                            @method('PUT')
                            <div class="form-group row">
                                <label for="email" class="col-md-4 col-form-label text-md-right font-weight-bold">{{ __('Name') }}</label>

                                <div class="col-md-6">
                                    <input id="email" type="text" class="form-control border-dark @error('name') is-invalid @enderror" name="name" value="{{ $user->name }}" required autofocus>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="email" class="col-md-4 col-form-label text-md-right font-weight-bold">{{ __('New E-mail Address') }}</label>

                                <div class="col-md-6">
                                    <input id="email" type="email" class="form-control border-dark @error('email') is-invalid @enderror" name="email" value="{{ $user->email }}" required autofocus>

                                    @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="password" class="col-md-4 col-form-label text-md-right font-weight-bold">{{ __('Password') }}</label>

                                <div class="col-md-6">
                                    <input id="password" type="password" class="form-control border-dark @error('password') is-invalid @enderror" name="password">
                                </div>
                            </div>

                            <div class="form-group row mb-0">
                                <div class="col-md-8 offset-md-4">
                                    <button type="submit" class="btn btn-dark text-danger font-weight-bold">
                                        {{ __('Update') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-8 offset-3">
                <div class="card bg-secondary mb-5">
                    <div class="card-body">

                        <form method="POST" action="{{ route('profile.update.detail') }}">
                            @csrf

                            @method('PUT')
                            <div class="form-group row">
                                <label for="phone" class="col-md-4 col-form-label text-md-right font-weight-bold">{{ __('Phone') }}</label>

                                <div class="col-md-6">
                                    <input id="phone" type="text" class="form-control border-dark @error('phone') is-invalid @enderror" name="phone" value="{{ optional($user->detail)->phone }}" autofocus>

                                    @error('phone')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="address" class="col-md-4 col-form-label text-md-right font-weight-bold">{{ __('Address') }}</label>

                                <div class="col-md-6">
                                    <input id="address" type="text" class="form-control border-dark @error('address') is-invalid @enderror" name="address" value="{{ optional($user->detail)->address }}" autofocus>

                                    @error('address')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="city" class="col-md-4 col-form-label text-md-right font-weight-bold">{{ __('City') }}</label>

                                <div class="col-md-6">
                                    <input id="city" type="text" class="form-control border-dark @error('city') is-invalid @enderror" name="city" value="{{ optional($user->detail)->city }}" autofocus>

                                    @error('city')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="country" class="col-md-4 col-form-label text-md-right font-weight-bold">{{ __('Country') }}</label>

                                <div class="col-md-6">
                                    <input id="country" type="text" class="form-control border-dark @error('country') is-invalid @enderror" name="country" value="{{ optional($user->detail)->country }}" autofocus>

                                    @error('country')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="uProfession" class="col-md-4 col-form-label text-md-right font-weight-bold">{{ __('Profession') }}</label>

                                <div class="col-md-6">
                                    <select name="userProfession[]" multiple="multiple" id="multiSelect">
                                        @foreach ($professions as $profession)
                                            <option value="{{ $profession->id }}" @if($user->professions->contains($profession->id)) selected @endif>{{ $profession->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row mb-0">
                                <div class="col-md-8 offset-md-4">
                                    <button type="submit" class="btn btn-dark text-danger font-weight-bold">
                                        {{ __('Update') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mb-4">
            <div class="col-md-8 offset-3">
                <div class="card bg-secondary">
                    <div class="card-header d-flex justify-content-center font-weight-bold" style="font-size: 20px">Galleries</div>
                    <div class="card-body">
                        @if($user->galleries->isEmpty())
                            <h2 class = "text-dark d-flex justify-content-center">No gallery available</h2>
                        @endif
                        <div class="row">
                            @foreach($user->galleries as $gallery)
                                <div class="col-md-6 mb-3">
                                    <div class="d-flex justify-content-center">
                                        <a href="{{ route('gallery.edit', ['gallery' => $gallery->id]) }}" class="text-decoration-none text-secondary">
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
    </div>
@endsection
