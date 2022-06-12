<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tour extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function tourDates() 
    {
        return $this->hasMany(TourDate::class, 'tour_id', 'id');
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class, 'tour_id', 'id');
    }
}
