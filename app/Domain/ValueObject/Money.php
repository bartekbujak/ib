<?php
declare(strict_types=1);

namespace App\Domain\ValueObject;

class Money
{
    public function __construct(private int $value, private string $currency = 'usd')
    {
        //todo add validation
    }

    public function __toString(): string
    {
        return $this->value / 100 . ' ' . $this->currency;
    }

    public function multiply(int $multiplier): Money
    {
        return new Money($this->value * $multiplier, $this->currency);
    }
}
