<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Booking;
use App\Models\Schedule;
use App\Enums\BookingStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Resources\BookingResource;
use App\Http\Requests\GetBookingRequest;
use App\Http\Requests\StoreBookingRequest;
use App\Http\Requests\UpdateBookingRequest;

class BookingController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Booking::class, 'booking');
    }

    public function index(GetBookingRequest $request)
    {
        $bookings = Booking::with('schedule');

        if( !$request->user()->is_admin )
            $bookings->where('user_id', $request->user()->id);

        if( $owner_id = $request->user_id )
            $bookings->where('user_id', $owner_id);

        $status = $request->status;
        if( !is_null($status) )
            $bookings->where('status', $status);

        $bookings = $bookings->get();

        return response()->json([
            'count' => $bookings->count(),
            'data' => $bookings
        ]);
    }

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

    public function show(Request $request, Booking $booking)
    {
        return BookingResource::make($booking);
    }

    public function update(UpdateBookingRequest $request, Booking $booking)
    {
        $scheduleWasBooked = $booking->schedule->is_booked;

        if( $scheduleWasBooked && $request->validated()['status'] == BookingStatus::APPROVED->value) {
            return response()->json([
                'message' => 'Schedule not available, already booked'
            ], 422);
        }

        try{
            DB::beginTransaction();

            $booking->update($request->validated());

            if($booking->status == BookingStatus::APPROVED->value){
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

    public function destroy(Request $request, Booking $booking)
    {
        $booking->delete();

        return response()->noContent();
    }
}
