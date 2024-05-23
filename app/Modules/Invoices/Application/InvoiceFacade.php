<?php
declare(strict_types=1);

namespace App\Modules\Invoices\Application;

use App\Modules\Invoices\Api\Dto\InvoiceDTO;
use App\Modules\Approval\Api\ApprovalFacadeInterface;
use App\Modules\Invoices\Api\InvoiceFacadeInterface;
use App\Modules\Invoices\Domain\InvoiceRepository;
use Ramsey\Uuid\UuidInterface;

class InvoiceFacade implements InvoiceFacadeInterface
{
    public function __construct(
        private InvoiceRepository       $repository,
        private ApprovalFacadeInterface $approvalFacade,
    ) {}

    public function find(UuidInterface $invoiceId): InvoiceDTO
    {
        $invoice = $this->repository->findOne($invoiceId);

        return InvoiceDTO::fromEntity($invoice);
    }

    public function approve(UuidInterface $invoiceId): void
    {
        $invoice = $this->repository->findOne($invoiceId);
        $invoice->approve($this->approvalFacade);
        $this->repository->save($invoice);
    }

    public function reject(UuidInterface $invoiceId): void
    {
        $invoice = $this->repository->findOne($invoiceId);
        $invoice->reject($this->approvalFacade);
        $this->repository->save($invoice);
    }
}
