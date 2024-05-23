<?php
declare(strict_types=1);

namespace App\Modules\Invoices\Domain\Entity;

use App\Domain\EntityInterface;
use App\Domain\ValueObject\Money;
use Ramsey\Uuid\UuidInterface;

class ProductLine implements EntityInterface
{
    public function __construct(
        private UuidInterface $id,
        private Product $product,
        private int $quantity,
    ) {}

    public function toArray(): array
    {
        $product = $this->product->toArray();

        return [
            'id' => $this->id->toString(),
            'name' => $product['name'],
            'price' => (string) $product['price'],
            'total' => (string) $this->calculateTotal(),
        ];
    }

    public function calculateTotal(): Money
    {
        return $this->product->price()->multiply($this->quantity);
    }
}
