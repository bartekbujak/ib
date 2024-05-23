<?php
declare(strict_types=1);

namespace Tests\Unit\Modules\Invoices\Domain\Collection;

use App\Domain\ValueObject\Money;
use App\Modules\Invoices\Domain\Collection\ProductLineCollection;
use App\Modules\Invoices\Domain\Entity\Product;
use App\Modules\Invoices\Domain\Entity\ProductLine;
use Ramsey\Uuid\Uuid;
use Tests\TestCase;

class ProductLineCollectionTest extends TestCase
{
    public function testGetTotalPrice()
    {
        $productLine1 = $this->createMock(ProductLine::class);
        $productLine1->method('calculateTotal')->willReturn(new Money(1000)); // $10.00
        $productLine2 = $this->createMock(ProductLine::class);
        $productLine2->method('calculateTotal')->willReturn(new Money(500)); // $5.00

        $id1 = "d9890249-0c08-4757-87ae-92abb526978f";
        $id2 = "4f00c838-e60d-454f-bf1c-a054db33db34";

        $product1 = new Product(Uuid::fromString($id1),'Product A', new Money(1000)); //10$
        $product2 = new Product(Uuid::fromString($id1),'Product B', new Money(2000)); //20$


        $productLine1 = new ProductLine(Uuid::fromString($id1), $product1, 2);
        $productLine2 = new ProductLine(Uuid::fromString($id2), $product2, 1);

        $collection = new ProductLineCollection();
        $collection->addProductLine($productLine1);
        $collection->addProductLine($productLine2);

        $totalPrice = $collection->getTotalPrice();

        $this->assertInstanceOf(Money::class, $totalPrice);
        $this->assertSame('40 usd', (string) $totalPrice);
    }
}