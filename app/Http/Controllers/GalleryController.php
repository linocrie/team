<?php

namespace App\Http\Controllers;

use App\Http\Requests\GalleryRequest;
use App\Models\Gallery;
use App\Models\GalleryImages;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class GalleryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function create(): View
    {
        return view('galleries.create');
    }

    public function store(GalleryRequest $request): RedirectResponse
    {
        $gallery = Gallery::create([
            'user_id' => auth()->user()->id,
            'title'   => $request->title
        ]);

        if($files = $request->file('gallery')) {
            foreach ($files as $file) {
                $fileName = $file->store('galleryImages');;
                $gallery->images()->create([
                    'original_name' => $file->getClientOriginalName(),
                    'path' => $fileName
                ]);
            }
        }

        return redirect()
            ->route('profile.index')
            ->with('success', 'Gallery successfully created');
    }

    public function edit(Gallery $gallery): View
    {
        return view('galleries.edit')
            ->with('gallery', $gallery->load('images'));
    }

    public function show($id): View
    {
        return view('galleries.images')
            ->with('images', GalleryImages::where('gallery_id', $id)->get());
    }

    public function update(GalleryRequest $request, Gallery $gallery): RedirectResponse
    {
        $gallery->update([
            'title'   => $request->title
        ]);

        if($files = $request->file('gallery')) {
            foreach ($files as $file) {
                $fileName = $file->store('galleryImages');;
                $gallery->images()->create([
                    'original_name' => $file->getClientOriginalName(),
                    'path' => $fileName
                ]);
            }
        }

        return redirect()
            ->route('profile.index')
            ->with('success', 'Gallery successfully updated');
    }

    public function delete(GalleryImages $images): RedirectResponse
    {
        if(Storage::exists($path = $images->path)) {
            Storage::delete($path);
        }

        $images->delete();

        return back()
            ->with('success', 'Image successfully deleted');
    }

    public function destroy(Gallery $gallery): RedirectResponse
    {
        if($gallery->images()->exists()) {
            Storage::delete($gallery->images->pluck('path')->all());
            $gallery->images()->delete();
        }

        $gallery->delete();

        return redirect()
            ->route('profile.index')
            ->with('success', 'Gallery successfully deleted');
    }
}
