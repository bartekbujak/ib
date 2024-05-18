<?php
declare(strict_types=1);

namespace App\Modules\Invoices\Domain\Entity;

use App\Domain\EntityInterface;

class ProductLine implements EntityInterface
{
    public function __construct(
        private int $id,
        private string $name,
        private int $quantity,
    ) {}

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'quantity' => $this->quantity,
        ];
    }
}