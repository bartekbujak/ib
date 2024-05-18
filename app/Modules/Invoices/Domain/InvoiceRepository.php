<?php
declare(strict_types=1);

namespace App\Modules\Invoices\Domain;

use App\Modules\Invoices\Domain\Entity\Invoice;
use Ramsey\Uuid\UuidInterface;

interface InvoiceRepository
{
    public function save(Invoice $invoice): void;
    public function findOne(UuidInterface $uuid): Invoice;
}