<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Subdistrict;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\SubdistrictResource;
use App\Http\Requests\StoreSubdistrictRequest;
use App\Http\Requests\UpdateSubdistrictRequest;

class SubdistrictController extends Controller
{
    public function index()
    {
        // $subdistrics = Subdistrict::with('city.province')->get();
        // TODO: filter by parent case
        $subdistrics = Subdistrict::all();

        return response()->json(['data' => $subdistrics]);
    }

    public function store(StoreSubdistrictRequest $request)
    {
        $subdistrict = Subdistrict::create($request->validated());

        return SubdistrictResource::make($subdistrict);
    }

    public function show(Subdistrict $subdistrict)
    {
        return SubdistrictResource::make($subdistrict);
    }

    public function update(UpdateSubdistrictRequest $request, Subdistrict $subdistrict)
    {
        $subdistrict->update($request->validated());

        return SubdistrictResource::make($subdistrict);
    }

    public function destroy(Subdistrict $subdistrict)
    {
        $subdistrict->delete();
        
        return response()->noContent();
    }
}
