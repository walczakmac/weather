<?php

namespace App\Infrastructure\Musement;

use App\Infrastructure\Musement;
use GuzzleHttp;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\Response;

class Client implements Musement
{
    /**
     * @var GuzzleHttp\Client
     */
    private $client;

    /**
     * @var LoggerInterface
     */
    private $logger;

    public function __construct(GuzzleHttp\Client $client, LoggerInterface $logger)
    {
        $this->client = $client;
        $this->logger = $logger;
    }

    public function getCities() : array
    {
        try {
            $cities = $this->client->get('cities');
        } catch (GuzzleHttp\Exception\GuzzleException $e) {
            $this->logger->error(sprintf(
                'There was an error when trying to fetch cities data from Musement API: %s',
                $e->getMessage()
            ));

            return [];
        }

        if ($cities->getStatusCode() !== Response::HTTP_OK) {
            $this->logger->error(sprintf(
                'Musement API responded with status code %d when trying to fetch cities data',
                $cities->getStatusCode()
            ));

            return [];
        }

        return json_decode($cities->getBody(), true);
    }
}
