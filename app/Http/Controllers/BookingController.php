<?php

namespace App\Http\Controllers;

use App\Interfaces\BookingRepositoryContract;
use App\Http\Requests\BookingRequest;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    protected $bookingRepository;

    public function __construct(BookingRepositoryContract $bookingRepository)
    {
        $this->bookingRepository = $bookingRepository;
    }

    public function store(BookingRequest $request)
    {
        return response()->json(['data' => $this->bookingRepository->store($request)], 201);
    }

    public function findAll()
    {
        return response()->json(['bookings' => $this->bookingRepository->all()], 200);
    }

    public function findBooking($id)
    {
        return response()->json(['booking' => $this->bookingRepository->findById($id)], 200);
    }

    public function findBookingDates($id)
    {
        return response()->json(['dates' => $this->bookingRepository->findBookingDates($id)], 200);
    }

    public function findBookingPassengers($id)
    {
        return response()->json(['passengers' => $this->bookingRepository->findBookingPassengers($id)], 200);
    }

    public function removeBookingPassengers($id)
    {
        return response()->json(['data' => $this->bookingRepository->removeBookingPassengers($id)], 200);
    }

    public function updateBooking($id, Request $request)
    {
        return response()->json(['data' => $this->bookingRepository->updateBooking($id, $request)], 200);
    }
}
