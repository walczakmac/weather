<?php

namespace App\Tests\Domain\Exception;

use App\Domain\Exception\MissingForecastDetails;
use PHPUnit\Framework\TestCase;

/**
 * @covers \App\Domain\Exception\MissingForecastDetails
 */
class MissingForecastDetailsTest extends TestCase
{
    public function testObject() : void
    {
        $exception = new MissingForecastDetails('message');
        $this->assertSame('message', $exception->getMessage());
    }
}
