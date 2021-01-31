<?php

namespace App\Domain;

class Forecast
{
    /**
     * @var \DateTimeImmutable
     */
    private $date;

    /**
     * @var string
     */
    private $weatherConditions;

    public function __construct(\DateTimeImmutable $date, string $weatherConditions)
    {
        $this->date = $date;
        $this->weatherConditions = $weatherConditions;
    }

    public function date() : \DateTimeImmutable
    {
        return $this->date;
    }

    public function weatherConditions() : string
    {
        return $this->weatherConditions;
    }
}
