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
        $validatedData = $request->validated();
        $hasHouseSpesifications = isset($request->validated()['house_specifications']);
        $hasResidenceSpesifications = isset($request->validated()['residence_specifications']);
        $hasHouseImages = isset($request->validated()['house_images']);

        try{
            DB::beginTransaction();

            $house = new House($validatedData);
            $house->user_id = $request->user()->id;
            $house->save();

            if($hasHouseSpesifications){
                $houseSpesifications = $request->validated()['house_specifications'];
                $house->houseSpesifications()->createMany($houseSpesifications);
            }

            if($hasResidenceSpesifications){
                $residenceSpesifications = $request->validated()['residence_specifications'];
                $house->residenceSpesifications()->createMany($residenceSpesifications);
            }

            if($hasHouseImages){
                $houseImages = $request->validated(['house_images']);
    
                foreach ($houseImages as $houseImage) {
                    $imageNameToSave = 'house-' . date('Y-m-d-h-i-s-U') . '.' . $houseImage['image']->extension();
                    $imageData['file_path'] = 'img/properties/' . $imageNameToSave;
                    $imageData['sequence'] =  $houseImage['sequence'];
                    // $imageData['url'] = ;
                    $imageData['url'] = 'url/' . $imageNameToSave; //dummy
    
                    //TODO: upload image
    
                    $house->houseImages()->create($imageData);
                }
                
            }

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
