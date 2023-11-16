<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Schedule;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\ScheduleResource;
use App\Http\Requests\StoreScheduleRequest;

class ScheduleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $cities = Schedule::all(); //TODO: filter by date range
        
        return response()->json(['data' => $cities]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreScheduleRequest $request)
    {
        $schedule = Schedule::create($request->validated());

        return ScheduleResource::make($schedule);
    }

    /**
     * Display the specified resource.
     */
    public function show(Schedule $schedule)
    {
        return ScheduleResource::make($schedule);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Schedule $schedule)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Schedule $schedule)
    {
        $schedule->delete();

        return response()->noContent();
    }
}
