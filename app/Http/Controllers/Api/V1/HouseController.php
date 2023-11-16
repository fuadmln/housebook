<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\House;
use App\Models\HouseSpesification;
use Illuminate\Support\Facades\DB;
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
        $validatedData = $request->validated()
        $hasHouseSpesifications = isset($request->validated()['house_specifications']);

        try{
            DB::beginTransaction();

            $house = new House($validatedData);
            $house->user_id = $request->user()->id;
            $house->save();

            if($hasHouseSpesifications){
                $houseSpesifications = $request->validated()['house_specifications'];
                $house->houseSpesifications()->createMany($houseSpesifications);
            }

            // ResidentSpecs
            // HouseImages

            DB::commit();

            return response()->json([
                'data' => $house
            ], 201);
        } catch(\Exception $e) {
            DB::rollback();

            return response()->json([
                'message' => $e->getMessage()
            ], 500);
        }

        
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
