<?php

namespace App\Http\Controllers;
use App\Jobs\ThumbnailGenerator;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class UploadController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function update(Request $request): RedirectResponse
    {
        $user = auth()->user();
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($user->load(['avatar'])->avatar) {
            $pathExtension = pathinfo($user->avatar->path, PATHINFO_EXTENSION);
            $pathFileName = pathinfo($user->avatar->path, PATHINFO_FILENAME);
            Storage::delete('avatars/'.$pathFileName.'_thumbnail.'.$pathExtension);
            Storage::delete($user->avatar->path);
        }

        $file = $request->file('image')->store('avatars');

        ThumbnailGenerator::dispatch(auth()->user(), $file, $request->file('image')->getClientOriginalName());

        return back()
            ->with('success','Image successfully uploaded');
    }
}
