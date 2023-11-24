<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\HouseAccessibility;
use Illuminate\Http\Request;

class HouseAccessibilityController extends Controller
{
    public function index()
    {
        $houseAccessibilities =  HouseAccessibility::all();

        return response()->json([
            'count' => $houseAccessibilities->count(),
            'data' => $houseAccessibilities
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'house_id' => 'required|exists:houses,id',
            'place' => 'required|string|max:100',
            'duration' => 'required|string|max:100',
        ]);

        $houseAccess = HouseAccessibility::create($validated);

        return $houseAccess;
    }

    public function show(HouseAccessibility $houseaccessibility)
    {
        return $houseaccessibility;
    }

    public function update(Request $request, HouseAccessibility $houseaccessibility)
    {
        $validated = $request->validate([
            'place' => 'sometimes|required|string|max:100',
            'duration' => 'sometimes|required|string|max:100',
        ]);

        $houseaccessibility->update($validated);

        return $houseaccessibility;
    }

    public function destroy(HouseAccessibility $houseaccessibility)
    {
        $houseaccessibility->delete();

        return response()->noContent();
    }
}
