<?php
declare(strict_types=1);

namespace App\Domain\ValueObject;

readonly class Address
{
    public function __construct(
        private string  $street,
        private string  $city,
        private ZipCode $zipCode,
    ) {}

    public function toArray(): array
    {
        return ['street' => $this->street, 'city' => $this->city, 'zipCode' => (string) $this->zipCode];
    }
}
