<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\ResidenceSpesification;
use Illuminate\Http\Request;

class ResidenceSpesificationController extends Controller
{
    public function index()
    {
        $residenceSpesifications = ResidenceSpesification::all();

        return response()->json([
            'count' => $residenceSpesifications->count(),
            'data' => $residenceSpesifications
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'house_id' => 'required|exists:houses,id',
            'name' => 'required|string|max:100',
            'value' => 'required|string|max:100',
        ]);

        $residenceSpec = ResidenceSpesification::create($validated);

        return $residenceSpec;
    }

    public function show(ResidenceSpesification $residencespesification)
    {
        return $residencespesification;
    }

    public function update(Request $request, ResidenceSpesification $residencespesification)
    {
        $validated = $request->validate([
            'name' => 'sometimes|required|string|max:100',
            'value' => 'sometimes|required|string|max:100',
        ]);

        $residencespesification->update($validated);

        return $residencespesification;
    }

    public function destroy(ResidenceSpesification $residenceSpec)
    {
        $residenceSpec->delete();

        return response()->noContent();
    }
}
