<?php

namespace App\Tests\Domain\Exception;

use App\Domain\Exception\MissingForecastDetailsConditions;
use PHPUnit\Framework\TestCase;

/**
 * @covers \App\Domain\Exception\MissingForecastDetailsConditions
 */
class MissingForecastDetailsConditionsTest extends TestCase
{
    public function testObject() : void
    {
        $exception = new MissingForecastDetailsConditions('message');
        $this->assertSame('message', $exception->getMessage());
    }
}
