@extends('layouts.admin')
@section('admin_content')
    <div class="container">
        @if(session('success'))
            <span class="alert alert-success d-flex justify-content-center p-2">{{ session('success') }}</span>
        @endif
        <div class="mt-5">
            <div class="card bg-secondary mb-5">
                <div class="card-header font-weight-bold" style="font-size: 20px">Gallery list</div>
                <input type="hidden" id="hidden_page" value="1">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3 form-group w-25">
                            <select name="filter_gallery" class="custom-select" id="filterGallery">
                                <option value="all" selected>All galleries</option>
                                <option value="moreImages">has 5 and more images</option>
                                <option value="lastDays">created last 7 days</option>
                            </select>
                        </div>
                        <div class="col-md-1 w-25 form-group">
                             <select name="paginate" class="custom-select" id="page">
                                <option value="3" selected>3</option>
                                <option value="5">5</option>
                                <option value="7">7</option>
                                <option value="15">15</option>
                             </select>
                        </div>
                        <div class="col-md-4 w-50 ml-auto">
                            <input class="form-control" type="text" placeholder="Search" aria-label="Search"
                                   name="gallerySearch" id="gallerySearch">
                        </div>
                    </div>
                    <h3 class="d-flex justify-content-center" id="noGallery"></h3>
                    <div class="col-md-12 mt-2" id="gallery_block">
                        <table class="table table-striped table-dark" id="tableGallery">
                            <thead>
                            <tr>
                                <th scope="col">Gallery_id</th>
                                <th scope="col">Title</th>
                                <th scope="col">Created at</th>
                                <th scope="col">Updated at</th>
                                <th scope="col">Action</th>
                            </tr>
                            </thead>
                            <tbody id="galleryBody"></tbody>
                        </table>
                    </div>
                    <div id="empty">
                        <div id="paginate" class="d-flex justify-content-between ml-4 mr-4 mb-2">
                            <a href="" id="previousPage"
                               class="text-decoration-none p-1 mr-2 bg-dark text-white rounded"> << Previous</a>
                            <a href="" id="nextPage" class="text-decoration-none p-1 ml-2 bg-dark text-white rounded">Next
                                >></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
