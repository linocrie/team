@extends('layouts.admin')

@section('admin_content')
    <div class="container mt-5">
        <strong id="weather"></strong>
        <div class="card-body bg-secondary mb-5">
            <div class="section mt-3">
                <div class="filter d-flex align-items-center justify-content-between">
                    <div class="d-flex align-items-center">
                        <div class="form-group">
                            <select class="custom-select" name="filter" id="filter">
                                <option name="all_users" value="all" selected>All users</option>
                                <option name="have_post" value="1">Have a post</option>
                                <option name="doesnt_have_post" value="2">Doesn't have a post</option>
                                <option name="have_gallery" value="3">Have a gallery</option>
                                <option name="doesnt_have_gallery" value="4">Doesn't have a gallery</option>
                                <option name="have_profession" value="5">Have a profession</option>
                                <option name="doesnt_have_profession" value="6">Doesn't have a profession</option>
                                <option name="have_avatar" value="7">Have an avatar</option>
                                <option name="doesnt_have_avatar" value="8">Doesn't have an avatar</option>
                            </select>
                        </div>

                        <div class="form-group ml-2">
                            <select name="paginate" class="custom-select" id="paginate">
                                <option value="3" selected>3</option>
                                <option value="5">5</option>
                                <option value="7">7</option>
                                <option value="15">15</option>
                            </select>
                        </div>
                    </div>

                    <div class="search">
                        <input class="form-control" type="text" placeholder="Search" aria-label="Search" id="search"
                               name="search">
                    </div>
                </div>
            </div>

            <div class="mt-3 table-responsive" id="users_block">
                <table class="table table-dark w-100" id="tableUser">
                    <thead>
                    <tr class="text-center">
                        <th scope="col">User_id</th>
                        <th scope="col">Name</th>
                        <th scope="col">Email</th>
                        <th scope="col">Phone</th>
                        <th scope="col">Address</th>
                        <th scope="col">City</th>
                        <th scope="col">Country</th>
                        <th scope="col"></th>
                    </tr>
                    </thead>
                    <tbody id="rowSearch"></tbody>
                </table>
            </div>
            <div id="pagination">
                <div class="text-center mt-5 mb-2 d-flex justify-content-between">
                    <a href="" class="btn btn-dark previous"><< Previous</a>
                    <a href="" class="btn btn-dark next">Next >></a>
                </div>
            </div>
        </div>
    </div>
@endsection


