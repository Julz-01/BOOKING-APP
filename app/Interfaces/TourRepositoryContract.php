<?php

namespace App\Interfaces;

interface TourRepositoryContract
{
    public function store(array|object $data);

    public function all();

    public function findById(int $id);

    public function update(int $id, array|object $data);

    public function enable(int $id);

    public function disable(int $id);

    public function findTourDates(int $id);
}
