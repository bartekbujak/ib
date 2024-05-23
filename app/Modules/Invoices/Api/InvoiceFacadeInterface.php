<?php
declare(strict_types=1);

namespace App\Modules\Invoices\Api;


use App\Modules\Invoices\Api\Dto\InvoiceDTO;
use Ramsey\Uuid\UuidInterface;

interface InvoiceFacadeInterface
{
    public function find(UuidInterface $invoiceId): InvoiceDTO;
    public function approve(UuidInterface $invoiceId): void;
    public function reject(UuidInterface $invoiceId): void;
}
