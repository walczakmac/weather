<?php

namespace App\Tests\Domain;

use App\Domain\City;
use App\Domain\Forecast;
use PHPUnit\Framework\TestCase;

/**
 * @covers \App\Domain\City
 */
class CityTest extends TestCase
{
    public function testObject() : void
    {
        $city = new City('London', 111.11, 222.22);
        $this->assertSame('London', $city->name());
        $this->assertSame(111.11, $city->latitude());
        $this->assertSame(222.22, $city->longitude());
        $this->assertSame([], $city->forecasts());
    }

    public function testForecast() : void
    {
        $city = new City('London', 111.11, 222.22);
        $forecast1 = new Forecast(new \DateTimeImmutable(), 'Clear sky');
        $forecast2 = new Forecast(new \DateTimeImmutable(), 'Cloudy');
        $city->addForecasts($forecast1, $forecast2);

        $this->assertSame([$forecast1, $forecast2], $city->forecasts());
        $this->assertSame('London | Clear sky - Cloudy', $city->printForecast());

    }
}
