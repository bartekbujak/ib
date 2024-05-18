<?php
declare(strict_types=1);

namespace App\Modules\Invoices\Domain\Entity;

use App\Domain\AggregateRootInterface;
use App\Domain\Enums\StatusEnum;
use App\Modules\Invoices\Domain\Collection\ProductLineCollection;
use App\Modules\Invoices\Domain\ValueObject\Company;
use DateTimeImmutable;
use Ramsey\Uuid\UuidInterface;

class Invoice implements AggregateRootInterface
{
    private ProductLineCollection $productLineCollection;

    public function __construct(
        private UuidInterface $id,
        private string $invoiceNumber,
        private DateTimeImmutable $invoiceDate,
        private DateTimeImmutable $dueDate,
        private readonly Company $company,
        private readonly Company $billedCompany,
        private StatusEnum $status = StatusEnum::DRAFT,
    ) {
        $this->productLineCollection = new ProductLineCollection();
    }


    public function addProductLine(ProductLine $productLine): void
    {
        $this->productLineCollection->addProductLine($productLine);
    }

    public function approve(): void
    {
        if ($this->status !== StatusEnum::DRAFT) {
            throw new \LogicException('Cannot approve invoice');
        }
        $this->status = StatusEnum::APPROVED;
    }

    public function reject(): void
    {
        if ($this->status !== StatusEnum::DRAFT) {
            throw new \LogicException('Cannot reject invoice');
        }
        $this->status = StatusEnum::REJECTED;
    }

    public function status(): StatusEnum
    {
        return $this->status;
    }

    public function toArray(): array
    {
        $lines = [];
        foreach ($this->productLineCollection->get() as $productLine) {
            $lines[] = $productLine->toArray();
        }

        return [
            'id' => $this->id->toString(),
            'invoiceNumber' => $this->invoiceNumber,
            'invoiceDate' => $this->invoiceDate->format('Y-m-d'),
            'dueDate' => $this->dueDate->format('Y-m-d'),
            'company' => $this->company->toArray(),
            'billedCompany' => $this->billedCompany->toArray(),
            'status' => $this->status->value,
            'lines' => $lines,
        ];
    }
}