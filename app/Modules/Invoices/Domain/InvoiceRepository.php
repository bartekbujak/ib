<?php
declare(strict_types=1);

namespace App\Modules\Invoices\Domain;

use App\Modules\Invoices\Domain\Entity\Invoice;
use App\Modules\Invoices\Domain\Exception\InvoiceNotExistException;
use Ramsey\Uuid\UuidInterface;

interface InvoiceRepository
{
    public function save(Invoice $invoice): void;

    /**
     * @throws InvoiceNotExistException
     * @param UuidInterface $uuid
     * @return Invoice
     */
    public function findOne(UuidInterface $uuid): Invoice;
}
