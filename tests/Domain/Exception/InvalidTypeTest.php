<?php

namespace App\Tests\Domain\Exception;

use App\Domain\Exception\InvalidType;
use PHPUnit\Framework\TestCase;

/**
 * @covers \App\Domain\Exception\InvalidType
 */
class InvalidTypeTest extends TestCase
{
    public function testObject() : void
    {
        $exception = new InvalidType('message');
        $this->assertSame('message', $exception->getMessage());
    }
}
