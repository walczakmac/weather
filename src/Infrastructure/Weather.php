<?php

namespace App\Infrastructure;

interface Weather
{
    /**
     * @param float $latitude
     * @param float $longitude
     * @param int $days
     * @return array<mixed>
     */
    public function getForecastByLatLong(float $latitude, float $longitude, int $days) : array;
}
