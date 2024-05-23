<?php
declare(strict_types=1);

namespace App\Modules\Invoices\Infrastructure\Database\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;


/**
 * @property string $id UUID
 * @property string $number invoice number
 * @property string $date invoice date
 * @property string $due_date invoice due date
 * @property string $company
 * @property string $billed_company invoice billed company
 * @property string $status status of invoice
 * @property HasMany $productLines product lines {@see InvoiceProductLine}
 */
class InvoiceModel extends Model
{
    protected $table = 'invoices';
    protected $keyType = 'string';

    public $incrementing = false;

    public function invoiceLines(): HasMany
    {
        return $this->hasMany(InvoiceLineModel::class, 'invoice_id');
    }

    public function company(): BelongsTo
    {
        return $this->belongsTo(CompanyModel::class, 'company_id');
    }

    public function billedCompany(): BelongsTo
    {
        return $this->belongsTo(CompanyModel::class, 'billed_company_id');
    }
}
