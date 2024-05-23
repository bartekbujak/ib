<?php
declare(strict_types=1);

namespace App\Domain\ValueObject;

use InvalidArgumentException;

class ZipCode
{
    public function __construct(private string $zipCode) {
//        if (!preg_match('/^\d{5}(-\d{4})?$/', $this->zipCode)) {
//            throw new InvalidArgumentException('Invalid ZIP code format');
//        }
    }

    public function __toString(): string
    {
        return $this->zipCode;
    }
}
