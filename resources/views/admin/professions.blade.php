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
                        <div class="row">
                            <div class="col-md-4 form-group w-25">
                                <select name="filter_profession" class="custom-select" id="filterProfession">
                                    <option value="all" selected>All professions</option>
                                    <option value="withUsers">Professions selected by users</option>
                                    <option value="withPosts">Professions selected by posts</option>
                                    <option value="moreFiveUsers">Professions selected by more than 5 users</option>
                                    <option value="moreFivePosts">Professions selected by more than 5 posts</option>
                                </select>
                            </div>
                            <div class="col-md-3 form-group">
                                <select name="paginate" class="custom-select" id="paginate">
                                    <option value="3" selected>3</option>
                                    <option value="5">5</option>
                                    <option value="7">7</option>
                                    <option value="15">15</option>
                                </select>
                            </div>
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
                <div class="pagination">
                    <ul> </ul>
                </div>
            </div>
        </div>
    </div>
@endsection
