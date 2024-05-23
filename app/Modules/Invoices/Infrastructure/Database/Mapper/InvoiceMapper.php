<?php
declare(strict_types=1);

namespace App\Modules\Invoices\Infrastructure\Database\Mapper;

use App\Domain\Enums\StatusEnum;
use App\Domain\ValueObject\Money;
use App\Modules\Invoices\Domain\Entity\Invoice;
use App\Modules\Invoices\Domain\Entity\Product;
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
            CompanyMapper::fromModel($invoiceModel->company()->first()),
            CompanyMapper::fromModel($invoiceModel->billedCompany()->first()),
            StatusEnum::from($invoiceModel->status),
        );
        foreach ($lines as $line) {
            $product = new Product(
                Uuid::fromString($line->product->id),
                $line->product->name,
                new Money($line->product->price, $line->product->currency)
            );
            $invoice->addProductLine(new ProductLine(Uuid::fromString($line->id), $product, $line->quantity));
        }

        return $invoice;
    }

    public static function toInvoiceModel(Invoice $invoice): InvoiceModel
    {
        $array = $invoice->toArray();
        /** @var InvoiceModel $invoiceModel */
        $invoiceModel = InvoiceModel::query()->where('id', $array['id'])->firstOrFail();
        $invoiceModel->status = $array['status'];
        $invoiceModel->number = $array['invoiceNumber'];
        $invoiceModel->date = $array['invoiceDate'];
        $invoiceModel->due_date = $array['dueDate'];

        //@todo add relations

        return $invoiceModel;
    }

}
