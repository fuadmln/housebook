<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Subdistrict;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\SubdistrictResource;
use App\Http\Requests\StoreSubdistrictRequest;

class SubdistrictController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // $subdistrics = Subdistrict::with('city.province')->get();
        $subdistrics = Subdistrict::all();

        return response()->json(['data' => $subdistrics]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSubdistrictRequest $request)
    {
        $subdistrict = Subdistrict::create($request->validated());

        return SubdistrictResource::make($subdistrict);
    }

    /**
     * Display the specified resource.
     */
    public function show(Subdistrict $subdistrict)
    {
        return SubdistrictResource::make($subdistrict);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Subdistrict $subdistrict)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Subdistrict $subdistrict)
    {
        //
    }
}
