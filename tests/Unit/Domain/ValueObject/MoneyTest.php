<?php
declare(strict_types=1);

namespace Tests\Unit\Domain\ValueObject;

use App\Domain\ValueObject\Money;
use Tests\TestCase;

class MoneyTest extends TestCase
{
    public function testMultiply()
    {
        $money = new Money(1050); // $10.50
        $result = $money->multiply(3);
        $this->assertSame('31.5 usd', (string)$result);
    }

    public function testAdd()
    {
        $money1 = new Money(1000); // $10.00
        $money2 = new Money(500); // $5.00
        $result = $money1->add($money2);
        $this->assertSame('15 usd', (string)$result);
    }
}