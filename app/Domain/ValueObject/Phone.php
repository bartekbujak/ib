<?php
declare(strict_types=1);

namespace App\Domain\ValueObject;

readonly class Phone
{
    public function __construct(private string $phone) {
        //todo add validation
    }

    public function __toString(): string
    {
        return $this->phone;
    }
}