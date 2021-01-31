<?php

namespace App\Tests\Application;

use App\Application\Musement;
use App\Domain\City;
use App\Domain\City\Factory;
use App\Infrastructure\Musement\InMemoryClient;
use PHPUnit\Framework\TestCase;
use Psr\Log\Test\TestLogger;

class MusementTest extends TestCase
{
    public function testGetCities() : void
    {
        $client = new InMemoryClient([
            ['name' => 'London', 'latitude' => 111.11, 'longitude' => 222.22],
        ]);
        $factory = new Factory();
        $logger = new TestLogger();

        $musement = new Musement($client, $factory, $logger);
        $cities = $musement->getCities();

        $this->assertNotEmpty($cities);
        $this->assertCount(1, $cities);
        $this->assertInstanceOf(City::class, $cities[0]);
        $this->assertSame('London', $cities[0]->name());
        $this->assertSame(111.11, $cities[0]->latitude());
        $this->assertSame(222.22, $cities[0]->longitude());
    }

    public function testGetCitiesMissingNameException() : void
    {
        $client = new InMemoryClient([
            ['latitude' => 111.11, 'longitude' => 222.22],
        ]);
        $factory = new Factory();
        $logger = new TestLogger();

        $musement = new Musement($client, $factory, $logger);
        $cities = $musement->getCities();

        $this->assertEmpty($cities);
        $this->assertTrue($logger->hasErrorThatContains('Missing parameter "name" when creating city.'));
    }
}
