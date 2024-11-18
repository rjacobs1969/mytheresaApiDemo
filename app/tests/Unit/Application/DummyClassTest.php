<?php

declare(strict_types=1);

namespace App\Tests\Unit\Application;

use PHPUnit\Framework\TestCase;

class DummyClassTest extends TestCase
{
    public function testDummy() : void
    {
        $true = true;
        $false = false;
        self::assertTrue($true);
        self::assertFalse($false);
        self::assertIsBool($true);
        self::assertNotEquals($true, $false);
    }
}
