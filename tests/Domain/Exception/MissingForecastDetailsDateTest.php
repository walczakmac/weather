<?php

namespace App\Tests\Domain\Exception;

use App\Domain\Exception\MissingForecastDetailsDate;
use PHPUnit\Framework\TestCase;

/**
 * @covers \App\Domain\Exception\MissingForecastDetailsDate
 */
class MissingForecastDetailsDateTest extends TestCase
{
    public function testObject() : void
    {
        $exception = new MissingForecastDetailsDate('message');
        $this->assertSame('message', $exception->getMessage());
    }
}
