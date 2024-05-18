<?php
declare(strict_types=1);

namespace App\Domain\ValueObject;

readonly class ZipCode
{
    public function __construct(private string $zipCode) {
        //todo add validation
    }

    public function __toString(): string
    {
        return $this->zipCode;
    }
}