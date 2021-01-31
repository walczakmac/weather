<?php

namespace App\Domain;

class City
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var float
     */
    private $latitude;

    /**
     * @var float
     */
    private $longitude;

    /**
     * @var Forecast[]
     */
    private $forecasts;

    public function __construct(string $name, float $latitude, float $longitude)
    {
        $this->name = $name;
        $this->latitude = $latitude;
        $this->longitude = $longitude;
        $this->forecasts = [];
    }

    public function name() : string
    {
        return $this->name;
    }

    public function latitude() : float
    {
        return $this->latitude;
    }

    public function longitude() : float
    {
        return $this->longitude;
    }

    public function addForecasts(Forecast ...$forecasts) : void
    {
        foreach($forecasts as $forecast) {
            $this->forecasts[] = $forecast;
        }
    }

    /**
     * @return Forecast[]
     */
    public function forecasts() : array
    {
        return $this->forecasts;
    }

    public function printForecast() : string
    {
        $prefixes = [' | ', ' - '];
        $forecastLine = array_map(function(Forecast $forecast) use (&$prefixes) {
            return array_shift($prefixes).$forecast->weatherConditions();
        }, $this->forecasts);

        return sprintf('%s%s', $this->name, implode('', $forecastLine));
    }
}
