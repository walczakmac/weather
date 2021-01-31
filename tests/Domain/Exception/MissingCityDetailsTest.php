<?php

namespace App\Tests\Domain\Exception;

use App\Domain\Exception\MissingCityDetails;
use PHPUnit\Framework\TestCase;

/**
 * @covers \App\Domain\Exception\MissingCityDetails
 */
class MissingCityDetailsTest extends TestCase
{
    public function testObject() : void
    {
        $exception = new MissingCityDetails('name');
        $this->assertSame('Missing parameter "name" when creating city.', $exception->getMessage());
    }
}
