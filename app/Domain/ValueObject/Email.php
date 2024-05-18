<?php
declare(strict_types=1);

namespace App\Domain\ValueObject;

readonly class Email
{
    public function __construct(private string $email)
    {
        //todo add validation
    }

    public function __toString(): string
    {
        return $this->email;
    }
}