<?php

namespace App\Repositories;

use App\Interfaces\BookingRepositoryContract;
use App\Models\Booking;
use App\Services\BookingService;
use App\Services\TourDateService;

class BookingRepository implements BookingRepositoryContract
{
    protected $model, $bookingService;

    public function __construct(
        Booking $model,
        BookingService $bookingService
    ) {
        $this->model = $model;
        $this->bookingService = $bookingService;
    }

    public function store(array|object $data)
    {
        $booking = $this->model->create([
            'tour_id' => $data->tour_id,
            'tour_date' => $data->tour_date,
            'status' => 1
        ]);

        $this->bookingService->setPassenger($booking->id, $data);
    }

    public function all()
    {
        return $this->model->with('tour', 'booking_passengers')->orderBy('created_at', 'DESC')->get();
    }

    public function findById(int $id)
    {
        return $this->model->with('booking_passengers', 'tour')->firstWhere('id', $id);
    }

    public function findBookingDates(int $id)
    {
        return (new TourDateService())->tourDates($id);
    }

    public function findBookingPassengers(int $id)
    {
        return $this->bookingService->getPassengers($id);
    }

    public function removeBookingPassengers(int $id)
    {
        return $this->bookingService->removePassenger($id);
    }

    public function updateBooking(int $id, array|object $data)
    {
        $booking = $this->model->find($id);
        $booking->tour_date = $data->tour_date;
        $booking->status = $data->status;
        $booking->save();

        if (!empty($data->textFields)) {
            $this->bookingService->setPassenger($booking->id, $data);
        }

        return $booking;
    }
}
