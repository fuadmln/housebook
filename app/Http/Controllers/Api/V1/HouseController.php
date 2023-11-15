<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\House;
use App\Models\HouseSpesification;
use App\Http\Controllers\Controller;
use App\Http\Resources\HouseResource;
use App\Http\Requests\StoreHouseRequest;
use App\Http\Requests\UpdateHouseRequest;

class HouseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $houses = House::all();

        return response()->json([
            'data' => $houses
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreHouseRequest $request)
    {
        $house = new House($request->validated());
        $house->user_id = $request->user()->id;
        $house->save(); //try cactch
        
        return $house;//

        /* storing children
        // check if request has model data
        $house->houseSpesifications()->save(new HouseSpesification([
            'name' => 'tipe',
            'value' => '36',
        ])); //single
        $house->houseSpesifications->saveMany([
            new HouseSpesification($arrayData),
            new HouseSpesification($arrayData),
        ]); //multiple

        // HouseSpecs
        // ResidentSpecs
        // HouseImages
        */

        return $house;
    }

    /**
     * Display the specified resource.
     */
    public function show(House $house)
    {
        return HouseResource::make($house);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateHouseRequest $request, House $house)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(House $house)
    {
        $house->delete(); //try catch

        return response()->noContent();
    }
}
