<?php
declare(strict_types=1);

namespace App\Modules\Invoices\Infrastructure\Database\Repository;

use App\Modules\Invoices\Domain\Entity\Invoice;
use App\Modules\Invoices\Domain\Exception\InvoiceNotExistException;
use App\Modules\Invoices\Domain\InvoiceRepository;
use App\Modules\Invoices\Infrastructure\Database\Mapper\InvoiceMapper;
use App\Modules\Invoices\Infrastructure\Database\Model\InvoiceModel;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Ramsey\Uuid\UuidInterface;

class EloquentInvoiceRepository implements InvoiceRepository
{

    public function save(Invoice $invoice): void
    {
        $model = InvoiceMapper::toInvoiceModel($invoice);
        $model->save();
    }

    public function findOne(UuidInterface $uuid): Invoice
    {
        try {
            /** @var InvoiceModel $model */
            $model = InvoiceModel::query()->where('id', $uuid)->firstOrFail();
            return InvoiceMapper::fromInvoiceModel($model);
        } catch (ModelNotFoundException) {
            throw new InvoiceNotExistException();
        }
    }
}
