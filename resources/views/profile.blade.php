@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Hello {{ Auth::user()->name }}</div>

                    <div class="card-body">
                        <h6 class = "d-flex justify-content-center mb-3">Update your Email here</h6>

                        @if(Session::has('message'))
                            <span class="alert alert-danger d-flex justify-content-center p-1">{{ Session::get('message') }}</span>
                            {{ Session::forget('message') }}
                        @endif

                        <form method="POST" action="{{ route('profile') }}">
                            @csrf

                            <div class="form-group row">
                                <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('Old E-mail Address') }}</label>

                                <div class="col-md-6">
                                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="oldEmail" value="{{ old('email') }}" required autocomplete="email" autofocus>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('New E-mail Address') }}</label>

                                <div class="col-md-6">
                                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="newEmail" value="{{ old('email') }}" required autocomplete="email" autofocus>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="confirmEmail" class="col-md-4 col-form-label text-md-right">{{ __('Confirm New E-mail') }}</label>

                                <div class="col-md-6">
                                    <input id="confirmEmail" type="text" class="form-control @error('confirmEmail') is-invalid @enderror" name="confirmEmail">
                                </div>
                            </div>

                            <div class="form-group row mb-0">
                                <div class="col-md-8 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Update') }}
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
