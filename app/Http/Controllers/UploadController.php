<?php

namespace App\Http\Controllers;

use App\Jobs\ThumbnailGeneratorJob;
use App\Models\Avatar;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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
            Storage::delete($user->avatar->path);
        }

        $file = $request->file('image')->store('avatars');

        if(Storage::exists($file)) {
            Avatar::updateOrCreate(
                ['user_id' => $user->id],
                [
                    'original_name' => $request->file('image')->getClientOriginalName(),
                    'path' => $file
                ]
            );
        }

        return back()
            ->with('success','Image successfully uploaded');
    }
}
