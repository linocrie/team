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

    public function  index()
    {
        return view('admin.galleries')
            ->with('galleries',Gallery::with('user')->paginate(3));
    }

    public function search(Request $request): JsonResponse
    {
        $x = Gallery::with('user')->where('title', 'LIKE',"%{$request->search}%")->paginate(3);
        return response()->json($x);
    }

    public function delete(Gallery $gallery)
    {
        if($gallery->images()->exists()) {
            Storage::delete($gallery->images->pluck('path')->all());
            $gallery->images()->delete();
        }

        $gallery->delete();

        return back()
            ->with('success', 'Post successfully deleted');
    }

    public function filter(Request $request): JsonResponse
    {
        if ($request->filter == 0)
        {
            $result = Gallery::with('user')->get();
        }

        if ($request->filter == 1)
        {
            $result = Gallery::with('user')->has('images','>','2')->get();
        }

        if ($request->filter == 2)
        {
            $date = Carbon::today()->subDays(7);
            $result = Gallery::with('user')->where('created_at','>=',$date)->get();
        }

        return response()->json($result);
    }
}
