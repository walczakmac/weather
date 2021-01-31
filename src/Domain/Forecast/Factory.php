<?php

namespace App\Domain\Forecast;

use App\Domain\Exception\MissingForecastDetails;
use App\Domain\Exception\MissingForecastDetailsConditions;
use App\Domain\Exception\MissingForecastDetailsDate;
use App\Domain\Forecast;

class Factory
{
    /**
     * @param array<mixed> $forecastDetails
     * @return Forecast[]
     * @throws MissingForecastDetails|MissingForecastDetailsDate|MissingForecastDetailsConditions
     */
    public function createFrom(array $forecastDetails) : array
    {
        if (empty($forecastDetails['forecast']['forecastday'])) {
            throw new MissingForecastDetails();
        }

        $forecasts = [];
        foreach($forecastDetails['forecast']['forecastday'] as $dayForecast) {
            if (empty($dayForecast['date'])) {
                throw new MissingForecastDetailsDate();
            }
            $date = \DateTimeImmutable::createFromFormat('Y-m-d', $dayForecast['date']);
            if (false === $date) {
                throw new MissingForecastDetailsDate();
            }

            if (empty($dayForecast['day']['condition']['text'])) {
                throw new MissingForecastDetailsConditions();
            }

            $forecasts[] = new Forecast($date, $dayForecast['day']['condition']['text']);
        }

        return $forecasts;
    }
}
