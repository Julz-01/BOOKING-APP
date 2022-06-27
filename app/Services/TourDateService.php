<?php

namespace App\Services;

use App\Models\TourDate;

class TourDateService
{
    function setDate($data, $tourId)
    {
        foreach ($data as $val) {
            TourDate::create([
                'tour_id' => $tourId,
                'date' => $val['date'],
                'status' => 1
            ]);
        }
    }

    function enable($id)
    {
        $tourDate = TourDate::find($id);
        $tourDate->status = 1;
        $tourDate->save();
    }

    function disable($id)
    {
        $tourDate = TourDate::find($id);
        $tourDate->status = 0;
        $tourDate->save();
    }

    function tourDates($id)
    {
        $tourDates = TourDate::where('tour_id', $id)
            ->where('status', 1)->get();

        return $tourDates;
    }
}
