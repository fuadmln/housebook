<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Booking;
use App\Models\Schedule;
use App\Enums\BookingStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Resources\BookingResource;
use App\Http\Requests\StoreBookingRequest;
use App\Http\Requests\UpdateBookingRequest;

class BookingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Booking::with('schedule')->get();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBookingRequest $request)
    {
        $scheduleWasBooked = Schedule::find($request->validated()['schedule_id'])->is_booked;

        if( $scheduleWasBooked ){
            return response()->json([
                'message' => 'Schedule not available, already booked'
            ], 422);
        }

        $booking = new Booking($request->validated());
        $booking->user_id = $request->user()->id;
        $booking->save();

        return BookingResource::make($booking);
    }

    /**
     * Display the specified resource.
     */
    public function show(Booking $booking)
    {
        return BookingResource::make($booking);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBookingRequest $request, Booking $booking)
    {
        $scheduleWasBooked = $booking->schedule->is_booked;

        if( $scheduleWasBooked && $request->validated()['status'] == BookingStatus::ACCEPTED->value) {
            return response()->json([
                'message' => 'Schedule not available, already booked'
            ], 422);
        }

        try{
            DB::beginTransaction();

            $booking->update($request->validated());

            if($booking->status == 'ACCEPTED'){
                $booking->schedule->update(['is_booked' => true]);
            }

            DB::commit();

            return response()->json([
                'data' => $booking->load('schedule')
            ], 200);
        } catch (\Exception $e){
            DB::rollback();

            return response()->json([
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Booking $booking)
    {
        $booking->delete();

        return response()->noContent();
    }
}
