<?php

declare(strict_types=1);

namespace App\Tests\Unit\Money;

use PHPUnit\Framework\TestCase;
use App\Domain\Money\Currency;

class CurrencyTest extends TestCase
{
    public function testCannotCreateCurrencyWithoutIsoCode() : void
    {
        $this->expectException(\InvalidArgumentException::class);
        new Currency('');
    }

    public function testCannotCreateCurrencyWithInvalidLengthIsoCode() : void
    {
        $this->expectException(\InvalidArgumentException::class);
        new Currency('NOTVALID');
    }

    public function testCanCreateCurrencyWithValidIsoCode() : void
    {
        $currency = new Currency('EUR');
        $this->assertEquals('EUR', $currency->isoCode());
    }

    public function testCanCompareCurrencies() : void
    {
        $currency1 = new Currency('EUR');
        $currency2 = new Currency('EUR');
        $currency3 = new Currency('USD');

        $this->assertTrue($currency1->equals($currency2));
        $this->assertFalse($currency1->equals($currency3));
    }
}
