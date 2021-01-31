<?php

namespace App\Application;

use App\Domain\Exception\InvalidType;
use App\Domain\Exception\MissingCityDetails;
use App\Domain\City;
use App\Infrastructure\Musement as MusementClient;
use Psr\Log\LoggerInterface;

class Musement
{
    /**
     * @var MusementClient
     */
    private $client;

    /**
     * @var City\Factory
     */
    private $factory;

    /**
     * @var LoggerInterface
     */
    private $logger;

    public function __construct(MusementClient $client, City\Factory $factory, LoggerInterface $logger)
    {
        $this->client = $client;
        $this->factory = $factory;
        $this->logger = $logger;
    }

    /**
     * @return City[]
     */
    public function getCities() : array
    {
        $citiesDetails = $this->client->getCities();
        $cities = [];
        foreach($citiesDetails as $cityDetails) {
            try {
                $cities[] = $this->factory->createFrom($cityDetails);
            } catch (MissingCityDetails | InvalidType $e) {
                $this->logger->error($e->getMessage());
            }
        }

        return $cities;
    }
}
