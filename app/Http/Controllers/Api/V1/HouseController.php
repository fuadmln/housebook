<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\House;
use App\Models\HouseAccessibility;
use App\Models\HouseSpesification;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Resources\HouseResource;
use App\Http\Requests\GetHouseRequest;
use App\Models\ResidenceSpesification;
use App\Http\Requests\StoreHouseRequest;
use App\Http\Requests\UpdateHouseRequest;

class HouseController extends Controller
{
    public function index(GetHouseRequest $request)
    {
        $houses = House::query(); 
        
        $has_iframe = $request->has_iframe;
        $is_published = $request->is_published;
        $type = $request->type;

        if( $owner_id = $request->user_id) )
            $bookings->where('user_id', $owner_id);

        if( !is_null($has_iframe) ) {
            if($has_iframe) $houses->whereNotNull('iframe');
            else $houses->whereNull('iframe');
        }
        
        if( !is_null($is_published) )
            $houses->where('is_published', $is_published);
        
        if( !is_null($type) )
            $houses->where('type', $type);

        $houses = $houses->get();

        return response()->json([
            'count' => $houses->count(),
            'data' => $houses
        ]);
    }

    public function store(StoreHouseRequest $request)
    {
        $validatedData = $request->validated();
        $hasHouseSpesifications = isset($request->validated()['house_specifications']);
        $hasResidenceSpesifications = isset($request->validated()['residence_specifications']);
        $hasHouseAccessibilities = isset($request->validated()['house_accessibilities']);
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

            if($hasHouseAccessibilities){
                $houseAccessibilities = $request->validated()['house_accessibilities'];
                $house->houseAccessibilities()->createMany($houseAccessibilities);
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

    public function show(House $house)
    {
        return HouseResource::make($house);
    }

    public function update(UpdateHouseRequest $request, House $house)
    {
        $hasHouseSpesifications = isset($request->validated()['house_specifications']);
        $hasResidenceSpesifications = isset($request->validated()['residence_specifications']);
        $hasHouseAccessibilities = isset($request->validated()['house_accessibilities']);

        try{
            DB::beginTransaction();
        
            $house->update($request->validated());

            if($hasHouseSpesifications){
                foreach ($request->validated()['house_specifications'] as $houseSpesification) {
                    if( $houseSpesification['action'] == 'update' ){
                        $house->houseSpesifications
                            ->find($houseSpesification['id'])
                            ->update($houseSpesification);
                    } elseif ( $houseSpesification['action'] == 'delete' ) {
                        HouseSpesification::destroy($houseSpesification['id']);
                    }
                }
            }

            if($hasResidenceSpesifications){
                foreach ($request->validated()['residence_specifications'] as $residenceSpesification) {
                    if( $residenceSpesification['action'] == 'update' ){
                        $house->residenceSpesifications
                            ->find($residenceSpesification['id'])
                            ->update($residenceSpesification);
                    } elseif ( $residenceSpesification['action'] == 'delete' ) {
                        ResidenceSpesification::destroy($residenceSpesification['id']);
                    }
                }
            }

            if($hasHouseAccessibilities){
                foreach ($request->validated()['house_accessibilities'] as $houseAccessibility) {
                    if( $houseAccessibility['action'] == 'update' ){
                        $house->houseAccessibilities
                            ->find($houseAccessibility['id'])
                            ->update($houseAccessibility);
                    } elseif ( $houseAccessibility['action'] == 'delete' ) {
                        HouseAccessibility::destroy($houseAccessibility['id']);
                    }
                }
            }

            DB::commit();
            
            return response()->json([
                'data' => $house
            ], 200);

        } catch(\Exception $e) {
            DB::rollback();

            return response()->json([
                'message' => $e->getMessage()
            ], 500);
        }


    }

    public function destroy(House $house)
    {
        $house->delete();

        return response()->noContent();
    }
}
