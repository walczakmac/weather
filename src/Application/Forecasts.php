<?php

namespace App\Application;

use App\Domain\Exception\MissingForecastDetails;
use App\Domain\City;
use App\Domain\Exception\MissingForecastDetailsConditions;
use App\Domain\Exception\MissingForecastDetailsDate;
use App\Domain\Forecast;
use App\Infrastructure\Weather;
use Psr\Log\LoggerInterface;

class Forecasts
{
    /**
     * @var Weather
     */
    private $client;

    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * @var Forecast\Factory
     */
    private $factory;

    public function __construct(Weather $client, Forecast\Factory $factory, LoggerInterface $logger)
    {
        $this->client = $client;
        $this->factory = $factory;
        $this->logger = $logger;
    }

    /**
     * @param City $city
     * @return Forecast[]
     * @throws MissingForecastDetailsConditions
     * @throws MissingForecastDetailsDate
     */
    public function getForecastFor(City $city) : array
    {
        $forecastDetails = $this->client->getForecastByLatLong($city->latitude(), $city->longitude(), 2);
        try {
            $forecasts = $this->factory->createFrom($forecastDetails);
        } catch (MissingForecastDetails $e) {
            $this->logger->error(sprintf('Couldn\'t resolve forecast for city %s due to missing details', $city->name()));

            return [];
        }

        return $forecasts;
    }
}
