<?php

namespace App\Http\Controllers;

use App\Http\Requests\TourRequest;
use App\Models\Tour;
use App\Models\TourDate;
use App\Http\Helpers\TourDateHelper;

class TourController extends Controller
{
    public function store(TourRequest $request)
    {
        $tour = Tour::create([
            'name' => $request->name,
            'itinerary' => $request->itinerary,
            'status' => 1
        ]);

        TourDateHelper::setDate($request->textFields, $tour->id);

        return response()->json(['msg' => 'success'], 201);
    }

    public function findTours()
    {
        $tours = Tour::latest()
            ->get();

        return response()->json(['tours' => $tours], 200);
    }

    public function findTour($id)
    {
        $tour = Tour::with('tourDates')
            ->firstWhere('id', $id);

        return response()->json(['tour' => $tour], 200);
    }

    public function updateTour(TourRequest $request, $id)
    {
        $tour = Tour::find($id);
        $tour->name = $request->name;
        $tour->itinerary = $request->itinerary;
        $tour->save();

        if (!empty($request->textFields)) {
            TourDateHelper::setDate($request->textFields, $tour->id);
        }

        return response()->json(['msg' => 'success'], 201);
    }

    public function disableTourDate($id)
    {
        $tourDate = TourDate::find($id);
        $tourDate->status = 0;
        $tourDate->save();

        return response()->json(['msg' => 'success!'], 200);
    }

    public function enableTourDate($id)
    {
        $tourDate = TourDate::find($id);
        $tourDate->status = 1;
        $tourDate->save();

        return response()->json(['msg' => 'success!'], 200);
    }

    public function findTourDates($id)
    {
        $tourDates = TourDate::where('tour_id', $id)
            ->where('status', 1)->get();

        return response()->json(['tourDates' => $tourDates], 200);
    }
}
