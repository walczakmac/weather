<?php

namespace App\Domain\City;

use App\Domain\Exception\InvalidType;
use App\Domain\Exception\MissingCityDetails;
use App\Domain\City;

class Factory
{
    /**
     * @param array<mixed> $cityDetails
     * @return City
     * @throws MissingCityDetails
     */
    public function createFrom(array $cityDetails) : City
    {
        if (empty($cityDetails['name'])) {
            throw new MissingCityDetails('name');
        }
        if (empty($cityDetails['latitude'])) {
            throw new MissingCityDetails('latitude');
        }
        if (empty($cityDetails['longitude'])) {
            throw new MissingCityDetails('longitude');
        }

        return new City($cityDetails['name'], $cityDetails['latitude'], $cityDetails['longitude']);
    }
}
