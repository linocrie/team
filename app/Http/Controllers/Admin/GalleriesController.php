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
            $professions = Gallery
                ::filterByRelation()
                ->searchName()
                ->paginate($request->perPage);
            return response()->json($professions);
        }
        return view('admin.galleries');
    }


    public function destroy (Request $request){
        $imagePaths = GalleryImages::whereHas("gallery", function (Builder $query) use($request)
        {
                $query->where("id" , $request->deleteId);
        })->get()->pluck("path");
        Storage::delete($imagePaths);
        Gallery::where('id', $request->deleteId)->first()->images()->delete();
        Gallery::where('id', $request->deleteId)->delete();
    }
}

