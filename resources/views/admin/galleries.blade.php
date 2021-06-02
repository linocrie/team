@extends('layouts.admin')

@section('admin_content')
    <div class="container">
        <div class="">
            <div class="section d-flex justify-content-between mt-3">
                <div class="filter form-group row">
                    <label for="galleries" class="col-md-4 col-form-label text-md-right font-weight-bold">{{ __('Filter') }}</label>
                    <div class="col-md-6">
                        <select name="filter"  id="multiSelect">
                            <option value="0">all</option>
                            <option value="1">has 5 and more images</option>
                            <option value="2">created last 7 days</option>
                        </select>
                    </div>
                </div>
                <div class="search">
                    <input  id ='search' class="form-control" type="text" placeholder="Search" aria-label="Search">
                </div>
            </div>
            <div class="col-md-12 mt-5">
                <table class="table table-striped table-dark">
                    <thead>
                    <tr>
                        <th scope="col">Gallery_id</th>
                        <th scope="col">User Name</th>
                        <th scope="col">Title</th>
                        <th scope="col">Created At</th>
                        <th scope="col">Updated At</th>
                        <th scope="col">Delete</th>

                    </tr>
                    </thead>
                    <tbody id ="table">
                    @foreach($galleries as $gallery)
                        <tr>
                            <th scope="row">{{$gallery->id}}</th>
                            <td>{{$gallery->user->name}}</td>
                            <td>{{$gallery->title}}</td>
                            <td>{{$gallery->created_at}}</td>
                            <td>{{$gallery->updated_at}}</td>
                            <td>
                                <form action="{{route('admin.gallery.delete',['gallery' => $gallery->id])}}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit">
                                        Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                <div class="d-flex justify-content-center">
                    {{ $galleries->links('pagination::bootstrap-4') }}
                </div>
            </div>
        </div>
    </div>


@endsection

