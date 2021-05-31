@extends('layouts.admin')

@section('admin_content')
    <div class="container">
        <div class="">
            <div class="section d-flex justify-content-between mt-3">
                <div class="filter form-group row">
                    <label for="posts" class="col-md-4 col-form-label text-md-right font-weight-bold">{{ __('Filter') }}</label>
                    <div class="col-md-6">
                        <select name="posts[]" multiple="multiple" id="multiSelect">
                            <option value="123">123</option>
                            <option value="456">123</option>
                            <option value="789">786</option>
                            {{--                            @foreach ($professions as $profession)--}}
                            {{--                                <option value="{{ $profession->id }}" @if($user->professions->contains($profession->id)) selected @endif>{{ $profession->name }}</option>--}}
                            {{--                            @endforeach--}}
                        </select>
                    </div>
                </div>
                <div class="search">
                    <input class="form-control" type="text" placeholder="Search" aria-label="Search">
                </div>
            </div>
            <div class="col-md-12 mt-5">
                <table class="table table-striped table-dark">
                    <thead>
                    <tr>
                        <th scope="col">User id</th>
                        <th scope="col">User name</th>
                        <th scope="col">Post id</th>
                        <th scope="col">Title</th>
                        <th scope="col">Description</th>
                        <th scope="col">Profession(s)</th>
                    </thead>
                    @foreach($posts as $post)
                        <tbody>
                        <tr>
                            <th scope="row">{{ $post->user->id }}</th>
                            <th scope="row">{{ $post->user->name }}</th>
                            <th scope="row">{{ $post->id }}</th>
                            <th scope="row">{{ $post->title }}</th>
                            <th scope="row">{{ $post->description }}</th>
                            <th scope="row">
                                <div class="d-flex flex-wrap">
                                @foreach($post->professions as $profession)
                                    <div class="mr-4">
                                        {{ $profession->name }}
                                    </div>
                                @endforeach
                                </div>
                            </th>
                        </tr>
                        </tbody>
                    @endforeach
                </table>
            </div>
        </div>
    </div>
    <div class="d-flex justify-content-center">
        {{ $posts->links('pagination::bootstrap-4') }}
    </div>


@endsection

