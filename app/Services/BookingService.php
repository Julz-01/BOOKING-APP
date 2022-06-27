<?php

namespace App\Services;

use App\Models\BookingPassenger;
use App\Models\Passenger;

class BookingService
{
    function setPassenger($bookingId, $data)
    {
        foreach ($data->textFields as $value) {
            $passenger = Passenger::create([
                'given_name' => $value['given_name'],
                'surname' => $value['surname'],
                'email' => $value['email'],
                'mobile' => $value['mobile'],
                'passport' => $value['passport'],
                'birth_date' => $value['birth_date'],
                'status' => 1
            ]);

            BookingPassenger::create([
                'booking_id' => $bookingId,
                'passenger_id' => $passenger->id,
                'special_request' => $value['special_request']
            ]);
        }
    }

    function getPassengers($id)
    {
        $passengers = BookingPassenger::with('passenger')
            ->where('booking_id', $id)
            ->latest()->get();

        return $passengers;
    }

    function removePassenger($id)
    {
        $bookingPassenger = BookingPassenger::find($id);
        $bookingPassenger->delete();
    }
}
