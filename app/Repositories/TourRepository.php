<?php

namespace App\Repositories;

use App\Interfaces\TourRepositoryContract;
use App\Models\Tour;
use App\Services\TourDateService;

class TourRepository implements TourRepositoryContract
{
    protected $model, $tourDateService;

    public function __construct(
        Tour $model,
        TourDateService $tourDateService
    ) {
        $this->model = $model;
        $this->tourDateService = $tourDateService;
    }

    public function store(array|object $data)
    {
        $tour = $this->model->create([
            'name' => $data->name,
            'itinerary' => $data->itinerary,
            'status' => 1
        ]);

        $this->tourDateService->setDate($data->textFields, $tour->id);

        return $tour;
    }

    public function all()
    {
        return $this->model->orderBy('created_at', 'DESC')->get();
    }

    public function findById(int $id)
    {
        return $this->model->with('tourDates')->firstWhere('id', $id);
    }

    public function update(int $id, array|object $data)
    {
        $tour = $this->model->find($id);
        $tour->name = $data->name;
        $tour->itinerary = $data->itinerary;
        $tour->save();

        if (!empty($data->textFields)) {
            $this->tourDateService->setDate($data->textFields, $tour->id);
        }

        return $tour;
    }

    public function enable(int $id)
    {
        return $this->tourDateService->enable($id);
    }

    public function disable(int $id)
    {
        return $this->tourDateService->disable($id);
    }

    public function findTourDates(int $id)
    {
        return $this->tourDateService->tourDates($id);
    }
}
