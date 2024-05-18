<?php
declare(strict_types=1);

namespace App\Modules\Invoices\Domain\Collection;

use App\Modules\Invoices\Domain\Entity\ProductLine;

class ProductLineCollection
{
    private array $productLines;
    public function __construct() {}

    public static function fromArray(array $productsLineArray): self
    {
        $collection = new self();

        return $collection;
    }

    public function addProductLine(ProductLine $productLine): void
    {
        $this->productLines[] = $productLine;
    }

    public function get(): array
    {
        return $this->productLines;
    }
}