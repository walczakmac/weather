<?php

namespace App\Tests\Domain\City;

use App\Domain\City;
use App\Domain\City\Factory;
use App\Domain\Exception\InvalidType;
use App\Domain\Exception\MissingCityDetails;
use PHPUnit\Framework\TestCase;

/**
 * @covers \App\Domain\City\Factory
 */
class FactoryTest extends TestCase
{
    public function testCreateSuccess() : void
    {
        $factory = new Factory();
        $city = $factory->createFrom([
            'name' => 'London',
            'latitude' => 111.00,
            'longitude' => 222.00,
        ]);

        $this->assertInstanceOf(City::class, $city);
        $this->assertSame('London', $city->name());
        $this->assertSame(111.00, $city->latitude());
        $this->assertSame(222.00, $city->longitude());
    }

    /**
     * @param array<mixed> $parameters
     * @param string $exceptionMessage
     * @throws MissingCityDetails
     * @dataProvider provideForMissingParameters
     */
    public function testMissingParameters(array $parameters, string $exceptionMessage) : void
    {
        $this->expectException(MissingCityDetails::class);
        $this->expectExceptionMessage($exceptionMessage);

        $factory = new Factory();
        $factory->createFrom($parameters);
    }

    /**
     * @return array<mixed>
     */
    public function provideForMissingParameters() : array
    {
        $cityMessage = 'Missing parameter "name" when creating city.';
        $latMessage = 'Missing parameter "latitude" when creating city.';
        $longMessage = 'Missing parameter "longitude" when creating city.';

        return [
            [['name' => '', 'latitude' => 111.11, 'longitude' => 222.22], $cityMessage],
            [['latitude' => 111.11, 'longitude' => 222.22], $cityMessage],
            [['name' => 'London', 'latitude' => 0, 'longitude' => 222.22], $latMessage],
            [['name' => 'London', 'longitude' => 222.22], $latMessage],
            [['name' => 'London', 'latitude' => 111.11, 'longitude' => 0], $longMessage],
            [['name' => 'London', 'latitude' => 111.11], $longMessage],
        ];
    }
}
