<?php

namespace App\Tests\Domain\Forecast;

use App\Domain\Exception\MissingForecastDetails;
use App\Domain\Exception\MissingForecastDetailsConditions;
use App\Domain\Exception\MissingForecastDetailsDate;
use App\Domain\Forecast;
use App\Domain\Forecast\Factory;
use PHPUnit\Framework\TestCase;

/**
 * @covers \App\Domain\Forecast\Factory
 */
class FactoryTest extends TestCase
{
    public function testCreateSuccess() : void
    {
        $factory = new Factory();
        $forecasts = $factory->createFrom([
            'forecast' => [
                'forecastday' => [
                    [
                        'date' => '2021-01-30',
                        'day' => ['condition' => ['text' => 'Clear sky']]
                    ],
                ]
            ]
        ]);

        $this->assertIsArray($forecasts);
        $this->assertCount(1, $forecasts);
        $this->assertInstanceOf(Forecast::class, $forecasts[0]);
        $this->assertInstanceOf(\DateTimeImmutable::class, $forecasts[0]->date());
        $this->assertSame('2021-01-30', $forecasts[0]->date()->format('Y-m-d'));
        $this->assertSame('Clear sky', $forecasts[0]->weatherConditions());
    }

    /**
     * @param array<mixed> $parameters
     * @throws MissingForecastDetails
     * @throws MissingForecastDetailsConditions
     * @throws MissingForecastDetailsDate
     * @dataProvider provideForMissingForecastDetails
     */
    public function testMissingForecastDetails(array $parameters) : void
    {
        $this->expectException(MissingForecastDetails::class);

        $factory = new Factory();
        $factory->createFrom($parameters);
    }

    /**
     * @return array<mixed>
     */
    public function provideForMissingForecastDetails() : array
    {
        return [
            [['forecast' => ['forecastday' => []]]],
            [['forecast' => []]],
            [[]],
        ];
    }

    /**
     * @param array<mixed> $parameters
     * @throws MissingForecastDetails
     * @throws MissingForecastDetailsConditions
     * @throws MissingForecastDetailsDate
     * @dataProvider provideForMissingForecastDetailsDate
     */
    public function testMissingForecastDetailsDate(array $parameters) : void
    {
        $this->expectException(MissingForecastDetailsDate::class);

        $factory = new Factory();
        $factory->createFrom($parameters);
    }

    /**
     * @return array<mixed>
     */
    public function provideForMissingForecastDetailsDate() : array
    {
        return [
            [['forecast' => ['forecastday' => [['date' => '', 'day' => ['condition' => ['text' => 'Clear sky']]]]]]],
            [['forecast' => ['forecastday' => [['day' => ['condition' => ['text' => 'Clear sky']]]]]]],
            [['forecast' => ['forecastday' => [['date' => '20210130', 'day' => ['condition' => ['text' => 'Clear sky']]]]]]],
        ];
    }

    /**
     * @param array<mixed> $parameters
     * @throws MissingForecastDetails
     * @throws MissingForecastDetailsConditions
     * @throws MissingForecastDetailsDate
     * @dataProvider provideForMissingForecastDetailsConditions
     */
    public function testMissingForecastDetailsConditions(array $parameters) : void
    {
        $this->expectException(MissingForecastDetailsConditions::class);

        $factory = new Factory();
        $factory->createFrom($parameters);
    }

    /**
     * @return array<mixed>
     */
    public function provideForMissingForecastDetailsConditions() : array
    {
        return [
            [['forecast' => ['forecastday' => [['date' => '2021-01-30', 'day' => ['condition' => ['text' => '']]]]]]],
            [['forecast' => ['forecastday' => [['date' => '2021-01-30', 'day' => ['condition' => []]]]]]],
            [['forecast' => ['forecastday' => [['date' => '2021-01-30', 'day' => []]]]]],
            [['forecast' => ['forecastday' => [['date' => '2021-01-30']]]]],
        ];
    }
}
