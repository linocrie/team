<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Gallery;
use App\Models\GalleryImages;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use JetBrains\PhpStorm\NoReturn;

class GalleriesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function  index(Request $request)
    {
        if ($request->expectsJson())
        {
            $gallery = Gallery
                ::filterByRelation()
                ->searchName()
                ->paginate($request->perPage);
            return response()->json($gallery);
        }
        return view('admin.galleries');
    }


    public function destroy (Gallery $gallery){
        $imagePaths = GalleryImages::whereHas("gallery", function (Builder $query) use($gallery)
        {
                $query->where("id" , $gallery->id);

        })->get()->pluck("path");
        Storage::delete($imagePaths);
        $gallery->images()->delete();
        $gallery->delete();
        return response()->json([]);
    }
}

