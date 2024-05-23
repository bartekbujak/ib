<?php
declare(strict_types=1);

namespace App\Modules\Invoices\Domain\Collection;

use App\Domain\ValueObject\Money;
use App\Modules\Invoices\Domain\Entity\ProductLine;

class ProductLineCollection
{
    /** @var ProductLine[] */
    private array $productLines;
    public function __construct() {}

    public function addProductLine(ProductLine $productLine): void
    {
        $this->productLines[] = $productLine;
    }

    public function get(): array
    {
        return $this->productLines;
    }

    public function getTotalPrice(): Money
    {
        $sum = new Money(0);
        foreach ($this->productLines as $productLine) {
            $sum = $sum->add($productLine->calculateTotal());
        }

        return $sum;
    }
}
