<?php

namespace App\Tests\Application;

use App\Application\Forecasts;
use App\Domain\City;
use App\Domain\Forecast;
use App\Domain\Forecast\Factory;
use App\Infrastructure\Weather\InMemoryClient;
use PHPUnit\Framework\TestCase;
use Psr\Log\Test\TestLogger;

class ForecastsTest extends TestCase
{
    public function testGetForecastsFor() : void
    {
        $client = new InMemoryClient('2021-01-30', 'Clear sky');
        $factory = new Factory();
        $logger = new TestLogger();
        $city = new City('London', 111.11, 222.22);

        $forecasts = new Forecasts($client, $factory, $logger);
        $forecasts = $forecasts->getForecastFor($city);

        $this->assertIsArray($forecasts);
        $this->assertCount(1, $forecasts);
        $this->assertInstanceOf(Forecast::class, $forecasts[0]);
        $this->assertSame('2021-01-30', $forecasts[0]->date()->format('Y-m-d'));
        $this->assertSame('Clear sky', $forecasts[0]->weatherConditions());
    }

    public function testGetForecastsForException() : void
    {
        $client = new InMemoryClient('', 'Clear sky');
        $factory = new Factory();
        $logger = new TestLogger();
        $city = new City('London', 111.11, 222.22);

        $forecasts = new Forecasts($client, $factory, $logger);
        $result = $forecasts->getForecastFor($city);

        $this->assertEmpty($result);
        $this->assertTrue($logger->hasErrorThatContains('Couldn\'t resolve forecast for city London due to missing details'));
    }
}
