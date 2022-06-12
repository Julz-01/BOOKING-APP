<?php

namespace App\Http\Controllers;

use App\Http\Helpers\BookingHelper;
use App\Http\Requests\BookingRequest;
use App\Models\Booking;
use App\Models\BookingPassenger;
use App\Models\TourDate;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function store(BookingRequest $request)
    {
        $booking = Booking::create([
            'tour_id' => $request->tour_id,
            'tour_date' => $request->tour_date,
            'status' => 1
        ]);

        BookingHelper::setPassenger($booking->id, $request);

        return response()->json(['msg' => 'success!'], 201);
    }

    public function findAll()
    {
        $bookings = Booking::with('tour', 'booking_passengers')
            ->latest()->get();

        return response()->json(['bookings' => $bookings], 200);
    }

    public function findBooking($id)
    {
        $booking = Booking::with('booking_passengers', 'tour')
            ->firstWhere('id', $id);

        return response()->json(['booking' => $booking], 200);
    }

    public function findBookingDates($id)
    {
        $dates = TourDate::where('tour_id', $id)
            ->where('status', 1)
            ->get();

        return response()->json(['dates' => $dates], 200);
    }

    public function findBookingPassengers($id)
    {
        $passengers = BookingPassenger::with('passenger')
            ->where('booking_id', $id)
            ->latest()->get();

        return response()->json(['passengers' => $passengers], 200);
    }

    public function removeBookingPassengers($id)
    {
        $bookingPassenger = BookingPassenger::find($id);
        $bookingPassenger->delete();

        return response()->json(['msg' => 'deleted!'], 200);
    }

    public function updateBooking($id, Request $request)
    {
        $booking = Booking::find($id);
        $booking->tour_date = $request->tour_date;
        $booking->status = $request->status;
        $booking->save();

        if (!empty($request->textFields)) {
            BookingHelper::setPassenger($booking->id, $request);
        }

        return response()->json(['msg' => 'success'], 200);
    }
}
