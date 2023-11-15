<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use App\Models\HouseSpesification;
use App\Http\Controllers\Controller;

class HouseSpesificationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return HouseSpesification::all();
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

        $houseSpec = HouseSpesification::create($validated);

        return $houseSpec;
    }

    /**
     * Display the specified resource.
     */
    public function show(HouseSpesification $houseSpec)
    {
        return $houseSpec;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(HouseSpesification $houseSpec)
    {
        $houseSpec->delete(); //try catch

        return response()->noContent();
    }
}
