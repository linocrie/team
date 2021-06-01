@extends('layouts.admin')

@section('admin_content')
    <div class="container">
        @if(session('success'))
            <span class="alert alert-success d-flex justify-content-center p-2">{{ session('success') }}</span>
        @endif
        <div class="mt-5">
            <div class="card bg-secondary mb-5">
                <div class="card-header font-weight-bold" style="font-size: 20px">Profession list</div>
                <input type="hidden" id="hidden_page" value="1">
                <div class="card-body">
                    <div class="section d-flex justify-content-between mt-3">
                        <div class="filter form-group w-25">
                            <select name="filter_profession" class="custom-select" id="filterProfession">
                                <option selected disabled>filter</option>
                                <option value="1">Professions selected by users</option>
                                <option value="2">Professions selected by posts</option>
                                <option value="3">Professions selected by more than 5 users</option>
                                <option value="4">Professions selected by more than 5 posts</option>
                            </select>
                        </div>
                        <div class="search">
                            <input class="form-control" type="text" placeholder="Search" aria-label="Search" name="professionSearch" id="professionSearch">
                        </div>
                    </div>
                    <h3 class="d-flex justify-content-center" id="noProfession"></h3>
                    <div class="col-md-12 mt-2" id="tableProf">
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
                            <tbody id="professionBody"></tbody>
                        </table>
                    </div>
                </div>
                <div class="d-flex justify-content-center mb-4" id="pagination">
                </div>
            </div>
        </div>
    </div>
@endsection
