<?php
declare(strict_types=1);

namespace App\Modules\Invoices\Infrastructure\Database\Mapper;

use App\Domain\Enums\StatusEnum;
use App\Modules\Invoices\Domain\Entity\Invoice;
use App\Modules\Invoices\Domain\Entity\ProductLine;
use App\Modules\Invoices\Infrastructure\Database\Model\InvoiceModel;
use Ramsey\Uuid\Uuid;

class InvoiceMapper
{
    public static function fromInvoiceModel(InvoiceModel $invoiceModel): Invoice
    {
        $lines = $invoiceModel->invoiceLines()->get();
        $invoice = new Invoice(
            Uuid::fromString($invoiceModel->id),
            $invoiceModel->number,
            new \DateTimeImmutable($invoiceModel->date),
            new \DateTimeImmutable($invoiceModel->due_date),
            CompanyMapper::fromArray(json_decode($invoiceModel->company,true)),
            CompanyMapper::fromArray(json_decode($invoiceModel->billed_company,true)),
            StatusEnum::from($invoiceModel->status),
        );
        foreach ($lines as $line) {
            $invoice->addProductLine(new ProductLine($line->id, '33', $line->quantity));
        }

        return $invoice;
    }

}