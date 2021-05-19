<?php

namespace App\Http\Controllers;

use App\Http\Requests\GalleryRequest;
use App\Models\Gallery;
use App\Models\GalleryImages;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class GalleryController extends Controller
{

    public function create(): View
    {
        return view('creategallery');
    }

    public function store(GalleryRequest $request): RedirectResponse
    {
        $lastGallery = Gallery::create([
            'user_id' => auth()->user()->id,
            'title'   => $request->title
        ]);

        if($files = $request->file('gallery')) {
            foreach ($files as $file) {
                $fileName = $file->store('galleryImages');;
                GalleryImages::create([
                    'gallery_id' => $lastGallery->id,
                    'original_name' => $file->getClientOriginalName(),
                    'path' => $fileName
                ]);
            }
        }

        return redirect()->route('profile.index')
            ->with('success', 'Gallery successfully created');
    }

    public function edit($id): View
    {
        return view('editgallery')
            ->with('gallery', Gallery::where('id', $id)->first()->load(['galleryImages']));
    }

    public function update(GalleryRequest $request, $id): RedirectResponse
    {
        Gallery::where('id', $id)->update([
            'title'   => $request->title
        ]);

        if($files = $request->file('gallery')) {
            foreach ($files as $file) {
                $fileName = $file->store('galleryImages');;
                GalleryImages::create([
                    'gallery_id' => $id,
                    'original_name' => $file->getClientOriginalName(),
                    'path' => $fileName
                ]);
            }
        }

        return redirect()->route('profile.index')
            ->with('success', 'Gallery successfully updated');
    }

    public function delete($id): RedirectResponse
    {
        $galleryImages = GalleryImages::where('id', $id);
        Storage::delete($galleryImages->first()->path);
        $galleryImages->delete();

        return redirect()->route('profile.index')
            ->with('success', 'Image successfully deleted');
    }

    public function destroy($id): RedirectResponse
    {
        $galleryImages = GalleryImages::where('gallery_id', $id);

        if($galleryImages->get()) {
            foreach ($galleryImages->get() as $images) {
                Storage::delete($images->path);
            }
            $galleryImages->delete();
        }

        Gallery::where('id', $id)->delete();

        return redirect()->route('profile.index')
            ->with('success', 'Gallery successfully deleted');
    }
}
