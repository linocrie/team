<?php

namespace App\Http\Controllers;

use App\Events\ProfessionCreatedOrUpdated;
use App\Http\Requests\DetailRequest;
use App\Jobs\DetailInsert;
use App\Mail\ProfessionCreated;
use App\Models\Detail;
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

        DetailInsert::dispatch($user,$request->all());

        $user->professions()->sync($request->userProfession);
        $updatedProfessions = $user->professions()->pluck('name')->all();

        event(new ProfessionCreatedOrUpdated($user->name, $beforeProfessions, $updatedProfessions));

        return back()
            ->with('success', 'Profile successfully updated');
    }
}
