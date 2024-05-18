<?php
declare(strict_types=1);

namespace App\Modules\Invoices\Api\Dto;

use App\Modules\Invoices\Domain\Entity\Invoice;

readonly class InvoiceDTO
{
    public function __construct(
        public string $id,
        public string $invoiceNumber,
        public string $invoiceDate,
        public string $dueDate,
        public array $company,
        public array $billedCompany,
        public string $status,
        public array $productLines
    ) {}

    public static function fromEntity(Invoice $invoice): self
    {
        $rawInvoice = $invoice->toArray();

        return new self(
            $rawInvoice['id'],
            $rawInvoice['invoiceNumber'],
            $rawInvoice['invoiceDate'],
            $rawInvoice['dueDate'],
            $rawInvoice['company'],
            $rawInvoice['billedCompany'],
            $rawInvoice['status'],
            $rawInvoice['lines'],
        );
    }

}