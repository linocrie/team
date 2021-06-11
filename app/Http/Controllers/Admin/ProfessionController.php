<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\ProfessionWeather;
use App\Models\Profession;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Http\JsonResponse;

class ProfessionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('is_admin');

    }

    public function index(Request $request)
    {
        $weather = new ProfessionWeather();
        $weatherInfo = $weather->getWeather();
        if ($request->expectsJson()) {
            $professions = Profession
                ::filterByRelation()
                ->searchName()
                ->paginate($request->perPage);

            return response()->json(["profession" => $professions, "weather" => $weatherInfo->json()]);

        }

        return view('admin.professions');
    }

    public function destroy(Profession $profession): JsonResponse
    {
        // onDelete cascade in migrations
        $profession->delete();
        return response()->json([]);
    }
}
