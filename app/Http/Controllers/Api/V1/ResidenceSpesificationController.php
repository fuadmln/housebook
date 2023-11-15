<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\ResidenceSpesification;
use Illuminate\Http\Request;

class ResidenceSpesificationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return ResidenceSpesification::all();
    }

    /**
     * Store a newly created resource in storage.
     */
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

    /**
     * Display the specified resource.
     */
    public function show(ResidenceSpesification $residenceSpec)
    {
        return $residenceSpec;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ResidenceSpesification $residenceSpec)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ResidenceSpesification $residenceSpec)
    {
        $residenceSpec->delete(); //try catch

        return response()->noContent();
    }
}
