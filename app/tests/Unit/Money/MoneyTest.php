<?php

declare(strict_types=1);

namespace App\Tests\Unit\Money;

use PHPUnit\Framework\TestCase;
use App\Domain\Money\Money;
use App\Domain\Money\Currency;

class MoneyTest extends TestCase
{
    public function testCanAddMoney() : void
    {
        $money1 = new Money(100, new Currency('EUR'));
        $money2 = new Money(200, new Currency('EUR'));

        $result = $money1->add($money2);

        $this->assertEquals(300, $result->amount());
        $this->assertEquals('EUR', $result->currency()->isoCode());
    }

    public function testCanSubtractMoney() : void
    {
        $money1 = new Money(200, new Currency('EUR'));
        $money2 = new Money(100, new Currency('EUR'));

        $result = $money1->subtract($money2);

        $this->assertEquals(100, $result->amount());
        $this->assertEquals('EUR', $result->currency()->isoCode());
    }

    public function testCannotAddMoneyWithDifferentCurrencies() : void
    {
        $this->expectException(\InvalidArgumentException::class);

        $money1 = new Money(100, new Currency('EUR'));
        $money2 = new Money(200, new Currency('USD'));

        $money1->add($money2);
    }

    public function testCannotSubtractMoneyWithDifferentCurrencies() : void
    {
        $this->expectException(\InvalidArgumentException::class);

        $money1 = new Money(200, new Currency('EUR'));
        $money2 = new Money(100, new Currency('USD'));

        $money1->subtract($money2);
    }

    public function testCanMultiplyMoney() : void
    {
        $money = new Money(100, new Currency('EUR'));

        $result = $money->multiply(2);

        $this->assertEquals(200, $result->amount());
        $this->assertEquals('EUR', $result->currency()->isoCode());
    }
}