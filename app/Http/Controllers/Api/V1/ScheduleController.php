<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Schedule;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\ScheduleResource;
use App\Http\Requests\GetScheduleRequest;
use App\Http\Requests\StoreScheduleRequest;
use App\Http\Requests\UpdateScheduleRequest;

class ScheduleController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Schedule::class, 'schedule');
    }

    public function index(GetScheduleRequest $request)
    {
        $dateFrom = $request->from;
        $dateTo = $request->to ? $request->to : $dateFrom;

        if($dateFrom)
            $schedules = Schedule::whereBetween('date', [$dateFrom, $dateTo])->get();
        else
            $schedules = Schedule::all();
        
        return response()->json([
            'count' => $schedules->count(),
            'data' => $schedules
        ]);
    }

    public function store(StoreScheduleRequest $request)
    {
        if ($request->validated('schedules')){
            $schedules = $request->validated()['schedules'];
            $date_time = now()->toDateTimeString();

            foreach($schedules as $key => $sch) {
                $schedules[$key]['created_at'] = $date_time;
                $schedules[$key]['updated_at'] = $date_time;
            }

            $schedule = Schedule::insert($schedules);

            return response()->noContent();
        }
        
        $schedule = Schedule::create($request->validated());
        
        return ScheduleResource::make($schedule);
    }

    public function show(Schedule $schedule)
    {
        return ScheduleResource::make($schedule);
    }

    public function update(UpdateScheduleRequest $request, Schedule $schedule)
    {
        $schedule->update($request->validated());

        return ScheduleResource::make($schedule);
    }

    public function destroy(Schedule $schedule)
    {
        $schedule->delete();

        return response()->noContent();
    }
}
