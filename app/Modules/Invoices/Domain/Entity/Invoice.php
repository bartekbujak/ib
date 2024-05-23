<?php
declare(strict_types=1);

namespace App\Modules\Invoices\Domain\Entity;

use App\Domain\AggregateRootInterface;
use App\Domain\Enums\StatusEnum;
use App\Modules\Approval\Api\ApprovalFacadeInterface;
use App\Modules\Approval\Api\Dto\ApprovalDto;
use App\Modules\Invoices\Domain\Collection\ProductLineCollection;
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
        private Company $company,
        private Company $billedCompany,
        private StatusEnum $status = StatusEnum::DRAFT,
    ) {
        $this->productLineCollection = new ProductLineCollection();
    }


    public function addProductLine(ProductLine $productLine): void
    {
        $this->productLineCollection->addProductLine($productLine);
    }

    public function approve(ApprovalFacadeInterface $facade): void
    {
        $dto = new ApprovalDto(
            $this->id,
            $this->status,
            Invoice::class,
        );
        $facade->approve($dto);
        $this->status = StatusEnum::APPROVED;
    }

    public function reject(ApprovalFacadeInterface $facade): void
    {
        $dto = new ApprovalDto(
            $this->id,
            $this->status,
            Invoice::class,
        );
        $facade->reject($dto);
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
