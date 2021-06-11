@extends('layouts.admin')

@section('admin_content')
    <div class="container">
        <div class="mt-5">
            <strong id="weather"></strong>
            <div class="card bg-secondary mb-5">
                <div class="card-header font-weight-bold" style="font-size: 20px">Profession list</div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3 form-group w-25">
                            <select name="filter_profession" class="custom-select" id="filterProfession">
                                <option value="all" selected>All professions</option>
                                <option value="withUsers">Professions selected by users</option>
                                <option value="withPosts">Professions selected by posts</option>
                                <option value="moreFiveUsers">Professions selected by more than 5 users</option>
                                <option value="moreFivePosts">Professions selected by more than 5 posts</option>
                            </select>
                        </div>
                        <div class="col-md-1 w-25 form-group">
                            <select name="perPage" class="custom-select" id="perPage">
                                <option value="3" selected>3</option>
                                <option value="5">5</option>
                                <option value="7">7</option>
                                <option value="15">15</option>
                            </select>
                        </div>
                        <div class="col-md-4 w-50 ml-auto">
                            <input class="form-control" type="text" placeholder="Search" aria-label="Search" name="professionSearch" id="professionSearch">
                        </div>
                    </div>
                    <h3 class="d-flex justify-content-center" id="noProfession"></h3>
                    <div class="col-md-12 mt-2" id="profession_block">
                        <table class="table table-striped table-dark" id="tableProfession">
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
                <div id="pageNone">
                    <div id="paginate" class="d-flex justify-content-between ml-4 mr-4 mb-2">
                        <a href="" id="previous" class="text-decoration-none p-1 mr-2 bg-dark text-white rounded"> << Previous</a>
                        <a href="" id="next" class="text-decoration-none p-1 ml-2 bg-dark text-white rounded">Next >></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
