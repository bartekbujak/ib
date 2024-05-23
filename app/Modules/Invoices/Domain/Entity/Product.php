<?php
declare(strict_types=1);

namespace App\Modules\Invoices\Domain\Entity;

use App\Domain\EntityInterface;
use App\Domain\ValueObject\Money;
use Ramsey\Uuid\UuidInterface;

class Product implements EntityInterface
{
    public function __construct(
        private UuidInterface $id,
        private string $name,
        private Money $price,
    ) {}

    public function price(): Money
    {
        return $this->price;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'price' => $this->price,
        ];
    }
}
