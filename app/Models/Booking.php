<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function tour()
    {
        return $this->belongsTo(Tour::class, 'tour_id', 'id');
    }

    public function booking_passengers()
    {
        return $this->hasMany(BookingPassenger::class, 'booking_id', 'id');
    }

    public function invoice()
    {
        return $this->hasOne(Invoice::class, 'booking_id', 'id');
    }
}
