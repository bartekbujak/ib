<?php
declare(strict_types=1);

namespace App\Modules\Invoices\Domain\ValueObject;

use App\Domain\ValueObject\Address;
use App\Domain\ValueObject\Email;
use App\Domain\ValueObject\Phone;

class Company
{
    public function __construct(
        private string $name,
        private Address $address,
        private Phone $phone,
        private ?Email $email = null,
    ){}

    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'address' => $this->address->toArray(),
            'phone' => (string) $this->phone,
            'email' => $this->email ? (string) $this->email : null,
        ];
    }
}