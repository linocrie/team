<?php

namespace App\Http\Controllers;

use App\Events\EmailProcessed;
use App\Http\Requests\GalleryRequest;
use App\Jobs\ThumbnailGeneratorJob;
use App\Mail\GalleryCreated;
use App\Models\Gallery;
use App\Models\GalleryImages;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Imagick;

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


    /**
     * @throws \ImagickException
     */
    public function store(GalleryRequest $request): RedirectResponse
    {
        $gallery = Gallery::create([
            'user_id' => auth()->id(),
            'title' => $request->title
        ]);

        if ($request->hasFile('galleries')) {
            foreach ($request->file('galleries') as $images) {
                $path = $images->store('galleryImages');
                $image = $gallery->images()->create([
                    'original_name' => $images->getClientOriginalName(),
                    'path' => $path,
                ]);

                ThumbnailGeneratorJob::dispatch($path, $image->id);
            }
        }
        event(new EmailProcessed($gallery));

        return redirect()
            ->route('profile.index')
            ->with('success', 'Gallery successfully created');
    }

    public function edit(Gallery $gallery): View
    {
        abort_if($gallery->user_id !== auth()->id(), 403, 'Unauthorized action.');

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
            'title' => $request->title
        ]);

        if ($request->hasFile('galleries')) {
            foreach ($request->file('galleries') as $images) {
                $path = $images->store('galleryImages');
                $gallery->images()->create([
                    'original_name' => $images->getClientOriginalName(),
                    'path' => $path
                ]);
            }
        }

        return redirect()
            ->route('profile.index')
            ->with('success', 'Gallery successfully updated');
    }

    public function delete(GalleryImages $images): RedirectResponse
    {
        $path = $images->path;
        $pathExtension = pathinfo($path, PATHINFO_EXTENSION);
        $thumbnail = pathinfo($path, PATHINFO_FILENAME) . '_thumbnail.' . $pathExtension;

        if (Storage::exists($path)) {

            Storage::delete($path);
        }

        if (Storage::exists('galleryImages/'.$thumbnail)) {

            Storage::delete('galleryImages/'.$thumbnail);
        }


        $images->delete();

        return back()
            ->with('success', 'Image successfully deleted');
    }

    public function destroy(Gallery $gallery): RedirectResponse
    {
        if ($gallery->images()->exists()) {

            Storage::delete($paths = $gallery->images->pluck('path')->all());

            foreach ($paths as $path) {
                $pathExtension = pathinfo($path, PATHINFO_EXTENSION);
                $thumbnail = pathinfo($path, PATHINFO_FILENAME) . '_thumbnail.' . $pathExtension;

                if (Storage::exists('galleryImages/'.$thumbnail)) {
                    Storage::delete('galleryImages/'.$thumbnail);
                }
            }
        }
        $gallery->images()->delete();
        $gallery->delete();

        return redirect()
            ->route('profile.index')
            ->with('success', 'Gallery successfully deleted');
    }
}
