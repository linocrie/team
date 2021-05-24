<?php

namespace App\Http\Controllers;

use App\Http\Requests\DetailRequest;
use App\Models\Detail;
use Illuminate\Http\RedirectResponse;

class DetailController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function update(DetailRequest $request): RedirectResponse
    {
        $user = auth()->user();
        Detail::updateOrCreate(
            ['user_id'    => $user->id],
            [
                'phone'   => $request->phone,
                'address' => $request->address,
                'city'    => $request->city,
                'country' => $request->country
            ]
        );
        $user->professions()->sync($request->userProfession);

        return back()
            ->with('success', 'Profile successfully updated');
    }
}
