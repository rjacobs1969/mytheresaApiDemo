<?php

declare(strict_types=1);

namespace App\Domain\Money;

class Money
{
    private int $amount;
    private Currency $currency;

    public function __construct(int $amount, Currency $currency)
    {
        $this->amount = $amount;
        $this->currency = $currency;
    }

    public function amount(): int
    {
        return $this->amount;
    }

    public function currency(): Currency
    {
        return $this->currency;
    }

    public function add(Money $money): Money
    {
        if (!$this->currency->equals($money->currency())) {
            throw new \InvalidArgumentException('Currencies must be the same');
        }

        return new Money($this->amount + $money->amount(), $this->currency);
    }

    public function subtract(Money $money): Money
    {
        if (!$this->currency->equals($money->currency())) {
            throw new \InvalidArgumentException('Currencies must be the same');
        }

        return new Money($this->amount - $money->amount(), $this->currency);
    }

    public function multiply(float $multiplier): Money
    {
        return new Money((int) ($this->amount * $multiplier), $this->currency);
    }
}
