@extends('layouts.admin')

@section('admin_content')
    <div class="container">
        <div class="">
            <div class="section d-flex justify-content-between mt-3">
                <div class="filter form-group row">
                    <label for="galleries" class="col-md-4 col-form-label text-md-right font-weight-bold">{{ __('Filter') }}</label>
                    <div class="col-md-6">
                        <select name="galleries[]" multiple="multiple" id="multiSelect">
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
                        <th scope="col">User_id</th>
                        <th scope="col">Title</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <th scope="row">1</th>
                        <td>Mark</td>
                        <td>Otto</td>
                        <td>@mdo</td>
                    </tr>
                    <tr>
                        <th scope="row">2</th>
                        <td>Jacob</td>
                        <td>Thornton</td>
                        <td>@fat</td>
                    </tr>
                    <tr>
                        <th scope="row">3</th>
                        <td>Larry</td>
                        <td>the Bird</td>
                        <td>@twitter</td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>


@endsection

