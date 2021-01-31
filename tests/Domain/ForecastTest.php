<?php

namespace App\Tests\Domain;

use App\Domain\Forecast;
use PHPUnit\Framework\TestCase;

/**
 * @covers \App\Domain\Forecast
 */
class ForecastTest extends TestCase
{
    public function testObject() : void
    {
        $date = \DateTimeImmutable::createFromFormat('Y-m-d H:i:s', '2021-01-03 12:00:00');
        $forecast = new Forecast($date, 'Clear sky');

        $this->assertSame('2021-01-03 12:00:00', $forecast->date()->format('Y-m-d H:i:s'));
        $this->assertSame('Clear sky', $forecast->weatherConditions());
    }
}
