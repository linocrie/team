@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center mt-4">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header d-flex justify-content-center">Gallery Images</div>
                    <div class="card-body">
                        @if($postUserImages->galleryImages->isEmpty())
                            <h2 class = "text-secondary m-auto">No images in this gallery</h2>
                        @endif
                        <div class="row">
                            @foreach($postUserImages->galleryImages as $images)
                                <div class="col-md-6">
                                    <div class="d-flex justify-content-center">
                                        <img src="{{ asset('storage/'.$images->path) }}" alt='avatar' class = 'img-fluid rounded-circle' style = "object-fit: cover; width: 200px; height: 200px;">
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
