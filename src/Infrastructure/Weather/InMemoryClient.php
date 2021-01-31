<?php


namespace App\Infrastructure\Weather;

use App\Infrastructure\Weather;

class InMemoryClient implements Weather
{
    /**
     * @var string
     */
    private $date;

    /**
     * @var string
     */
    private $weatherConditions;

    public function __construct(string $date, string $weatherConditions)
    {
        $this->date = $date;
        $this->weatherConditions = $weatherConditions;
    }

    public function getForecastByLatLong(float $latitude, float $longitude, int $days): array
    {
        return [
            'forecast' => [
                'forecastday' => [
                    [
                        'date' => $this->date,
                        'day' => ['condition' => ['text' => $this->weatherConditions]]
                    ]
                ]
            ]
        ];
    }
}
