<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\City;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\CityResource;
use App\Http\Requests\StoreCityRequest;
use App\Http\Requests\UpdateCityRequest;

class CityController extends Controller
{
    public function index(Request $request)
    {   
        $province_id = $request->query('province_id');

        if ($province_id)
            $cities = City::where('province_id', $province_id)->get();
        else $cities = City::all();
        
        return response()->json([
            'count' => $cities->count(),
            'data' => $cities
        ]);
    }

    public function store(StoreCityRequest $request)
    {
        $city = City::create($request->validated());

        return CityResource::make($city);
    }

    public function show(City $city)
    {
        return CityResource::make($city);
    }

    public function update(UpdateCityRequest $request, City $city)
    {
        $city->update($request->validated());

        return CityResource::make($city);
    }

    public function destroy(City $city)
    {
        $city->delete();
        
        return response()->noContent();
    }
}
