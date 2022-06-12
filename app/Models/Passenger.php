<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Passenger extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function booking_passengers()
    {
        return $this->hasMany(BookingPassenger::class, 'passenger_id', 'id');
    }
}
