<?php

namespace App\Infrastructure\Musement;

use App\Infrastructure\Musement;

class InMemoryClient implements Musement
{
    /**
     * @var array<mixed>
     */
    private $cities;

    /**
     * @param array<mixed> $cities
     */
    public function __construct(array $cities)
    {
        $this->cities = $cities;
    }

    public function getCities(): array
    {
        return $this->cities;
    }
}
