<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use App\Models\HouseSpesification;
use App\Http\Controllers\Controller;

class HouseSpesificationController extends Controller
{
    public function index()
    {
        $houseSpesifications = HouseSpesification::all();

        return response()->json([
            'count' => $houseSpesifications->count(),
            'data' => $houseSpesifications
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'house_id' => 'required|exists:houses,id',
            'name' => 'required|string|max:100',
            'value' => 'required|string|max:100',
        ]);

        $houseSpec = HouseSpesification::create($validated);

        return $houseSpec;
    }

    public function show(Request $request, HouseSpesification $housespesification)
    {
        return $housespesification;
    }

    public function update(Request $request, HouseSpesification $housespesification)
    {
        $validated = $request->validate([
            'name' => 'sometimes|required|string|max:100',
            'value' => 'sometimes|required|string|max:100',
        ]);

        $housespesification->update($validated);

        return $housespesification;
    }

    public function destroy(HouseSpesification $houseSpec)
    {
        $houseSpec->delete();

        return response()->noContent();
    }
}
