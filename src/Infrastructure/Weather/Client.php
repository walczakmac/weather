<?php

namespace App\Infrastructure\Weather;

use App\Infrastructure\Weather;
use GuzzleHttp;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\Response;

class Client implements Weather
{
    /**
     * @var GuzzleHttp\Client
     */
    private $client;

    /**
     * @var string
     */
    private $key;

    /**
     * @var LoggerInterface
     */
    private $logger;

    public function __construct(GuzzleHttp\Client $client, string $key, LoggerInterface $logger)
    {
        $this->client = $client;
        $this->key = $key;
        $this->logger = $logger;
    }

    public function getForecastByLatLong(float $latitude, float $longitude, int $days) : array
    {
        try {
            $response = $this->client->get('forecast.json', [
                'query' => [
                    'key' => $this->key,
                    'q' => sprintf('%f,%f', $latitude, $longitude),
                    'days' => $days,
                ]
            ]);
        } catch (GuzzleHttp\Exception\GuzzleException $e) {
            $this->logger->error(sprintf(
                'There was an error when trying to fetch forecast data from Weather API for following coordinates: %s, %s: %s',
                $latitude,
                $longitude,
                $e->getMessage()
            ));

            return [];
        }

        if ($response->getStatusCode() !== Response::HTTP_OK) {
            $this->logger->error(sprintf(
                'Weather API responded with status code %d when trying to fetch forecast data for following coordinates %s, %s',
                $response->getStatusCode(),
                $latitude,
                $longitude
            ));

            return [];
        }

        return json_decode($response->getBody(), true);
    }
}
