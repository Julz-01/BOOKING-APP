<?php

namespace App\Http\Helpers;

use App\Models\TourDate;

class TourDateHelper
{
    public static function setDate($data, $tourId)
    {
        foreach ($data as $val) {
            TourDate::create([
                'tour_id' => $tourId,
                'date' => $val['date'],
                'status' => 1
            ]);
        }
    }
}
