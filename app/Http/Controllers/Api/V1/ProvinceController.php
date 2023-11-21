<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Province;
use App\Models\Subdistrict; //
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\ProvinceResource;

class ProvinceController extends Controller
{
    public function index()
    {
        $provinces = Province::all();

        return response()->json([
            'count' => $provinces->count(),
            'data' => $provinces
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate(['name' => 'required|string|max:255']);

        $province = Province::create($validated);

        return ProvinceResource::make($province);
    }

    public function show(Province $province)
    {
        return ProvinceResource::make($province);
    }

    public function update(Request $request, Province $province)
    {
        $validated = $request->validate(['name' => 'sometimes|string|max:255']);
        $province->update($validated);

        return ProvinceResource::make($province);
    }

    public function destroy(Province $province)
    {
        $province->delete();
        
        return response()->noContent();
    }
}
