<?php

namespace App\Http\Controllers;

use App\Http\Requests\DetailRequest;
use App\Mail\ProfessionCreated;
use App\Models\Detail;
use App\Models\Profession;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class DetailController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function update(DetailRequest $request)
    {
        $user = auth()->user();

        $beforeProfessions = $user->professions->pluck('name')->all();

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
        $updatedProfessions = $user->professions()->pluck('name')->all();

        Mail::to('shant97@outlook.com')->send(new ProfessionCreated($user->name, $beforeProfessions, $updatedProfessions));

        return back()
            ->with('success', 'Profile successfully updated');
    }
}
