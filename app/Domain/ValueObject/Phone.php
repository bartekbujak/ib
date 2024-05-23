<?php
declare(strict_types=1);

namespace App\Domain\ValueObject;

use InvalidArgumentException;

class Phone
{
    public function __construct(private string $phone) {
//        if (!preg_match('/^\(\d{3}\) \d{3}-\d{4}$/', $this->phone)) {
//            throw new InvalidArgumentException('Invalid phone number format');
//        }
    }

    public function __toString(): string
    {
        return $this->phone;
    }
}
