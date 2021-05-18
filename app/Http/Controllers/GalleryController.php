<?php

namespace App\Http\Controllers;

use App\Http\Requests\GalleryRequest;
use App\Models\Gallery;
use App\Models\GalleryImages;
use Illuminate\Http\Request;
use Illuminate\View\View;

class GalleryController extends Controller
{

    public function index()
    {
        //
    }

    public function create(): View
    {
        return view('creategallery');
    }

    public function store(GalleryRequest $request)
    {
//        dd(Gallery::where('user_id', auth()->user()->id)->get());
        $lastGallery = Gallery::create([
            'user_id' => auth()->user()->id,
            'title'   => $request->title
        ]);

        foreach($request->file('gallery') as $file) {
            $fileName = $file->store('galleryImages');;
            GalleryImages::create([
                'gallery_id'    => $lastGallery->id,
                'original_name' => $file->getClientOriginalName(),
                'path'          => $fileName
            ]);
        }

        return redirect()->route('profile.index')
            ->with('success', 'Gallery successfully created');
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}
