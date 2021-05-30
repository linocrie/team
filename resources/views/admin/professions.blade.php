@extends('layouts.admin')

@section('admin_content')
    <div class="container">
        @if(session('success'))
            <span class="alert alert-success d-flex justify-content-center p-2">{{ session('success') }}</span>
        @endif
        <div class="mt-5">
            <div class="card bg-secondary mb-5">
                <div class="card-header font-weight-bold" style="font-size: 20px">Profession list</div>

                <div class="card-body">
                    <div class="section d-flex justify-content-between mt-3">
                        <div class="filter form-group row">
                            <label for="professions" class="form-label font-weight-bold">{{ __('Filter') }}</label>
                            <div class="col-md-6">
                                <select name="professions[]" multiple="multiple" id="filterMultiSelect">
                                    <option value="1">Professions selected by users</option>
                                    <option value="2">Professions selected by posts</option>
                                </select>
                            </div>
                        </div>
                        <div class="search">
                            <input class="form-control" type="text" placeholder="Search" aria-label="Search" name="professionSearch" id="professionSearch">
                        </div>
                    </div>
                    <h3 class="d-flex justify-content-center" id="noProfession"></h3>
                    <div class="col-md-12 mt-1" id="tableProf">
                        <table class="table table-striped table-dark">
                            <thead>
                            <tr>
                                <th scope="col">Id</th>
                                <th scope="col">Name</th>
                                <th scope="col">Created at</th>
                                <th scope="col">Updated at</th>
                                <th scope="col">Action</th>
                            </tr>
                            </thead>
                            <tbody id="professionBody">
                            @foreach($professions as $profession)
                                <tr>
                                    <td>{{ $profession->id }}</td>
                                    <td>{{ $profession->name }}</td>
                                    <td>{{ $profession->created_at }}</td>
                                    <td>{{ $profession->updated_at }}</td>
                                    <td>
                                        <form method="POST" action="{{ route('admin.profession.delete', ['profession' => $profession->id]) }}">
                                            @csrf

                                            @method('DELETE')
                                            <button type="submit" class="btn btn-white p-1">
                                                <i class="far fa-trash-alt text-white"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="d-flex justify-content-center mb-4" id="pagination">
                    {{ $professions->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
