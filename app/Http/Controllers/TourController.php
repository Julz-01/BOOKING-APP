<?php

namespace App\Http\Controllers;

use App\Interfaces\TourRepositoryContract;
use App\Http\Requests\TourRequest;

class TourController extends Controller
{
    protected $tourRepository;

    public function __construct(TourRepositoryContract $tourRepository)
    {
        $this->tourRepository = $tourRepository;
    }

    public function store(TourRequest $request)
    {
        return response()->json(['data' => $this->tourRepository->store($request)], 201);
    }

    public function findTours()
    {
        return response()->json(['tours' => $this->tourRepository->all()], 200);
    }

    public function findTour($id)
    {
        return response()->json(['tour' => $this->tourRepository->findById($id)], 200);
    }

    public function updateTour($id, TourRequest $request)
    {
        return response()->json(['msg' => $this->tourRepository->update($id, $request)], 201);
    }

    public function disableTourDate($id)
    {
        return response()->json(['msg' => $this->tourRepository->disable($id)], 200);
    }

    public function enableTourDate($id)
    {
        return response()->json(['msg' => $this->tourRepository->enable($id)], 200);
    }

    public function findTourDates($id)
    {
        return response()->json(['tourDates' => $this->tourRepository->findTourDates($id)], 200);
    }
}
