<?php 

namespace App\Interfaces;

interface BookingRepositoryContract 
{
    public function store(array|object $data); 

    public function all();

    public function findById(int $id);

    public function findBookingDates(int $id);

    public function findBookingPassengers(int $id);

    public function removeBookingPassengers(int $id);

    public function updateBooking(int $id, array|object $data);
}