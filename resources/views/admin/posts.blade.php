@extends('layouts.admin')

@section('admin_content')
    <div class="container">
        <div class="card-body bg-secondary mt-5 mb-5">
            <div class="section mt-3">
                <div class="filter d-flex align-items-center justify-content-between">
                    <div class="d-flex align-items-center">
                        <div class="form-group">
                            <select class="custom-select" name="filterPosts" id="filterPosts">
                                <option name="default" value="default" selected>Default (no filter)</option>
                                <option name="haveProfessions" value="haveProfessions">Have profession(s)</option>
                                <option name="haveNotProfessions" value="haveNotProfessions">Doesn't have profession(s)</option>
                            </select>
                        </div>

                        <div class="form-group ml-2">
                            <select name="paginatePosts" class="custom-select" id="paginatePosts">
                                <option value="3" selected>3</option>
                                <option value="5">5</option>
                                <option value="7">7</option>
                                <option value="15">15</option>
                            </select>
                        </div>
                    </div>

                    <div class="search">
                        <input class="form-control" type="text" placeholder="Search" aria-label="Search" id="searchPosts"
                               name="searchPosts">
                    </div>
                </div>
            </div>

            <div class="mt-3 table-responsive" id="posts_block">
                <table class="table table-dark w-100" id="tablePost">
                    <thead>
                    <tr class="text-center">
                        <th scope="col">Post_id</th>
                        <th scope="col">Title</th>
                        <th scope="col">Description</th>
                        <th scope="col">Profession(s)</th>
                        <th scope="col">Action</th>
                    </tr>
                    </thead>
                    <tbody id="postsBody"></tbody>
                </table>
            </div>
            <div id="paginationPosts">
                <div class="text-center mt-5 mb-2 d-flex justify-content-between">
                    <a href="" class="btn btn-dark previous"><< Previous</a>
                    <a href="" class="btn btn-dark next">Next >></a>
                </div>
            </div>
        </div>
    </div>
@endsection
