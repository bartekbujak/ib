<?php
declare(strict_types=1);

namespace App\Modules\Invoices\Infrastructure\Database\Model;


use App\Modules\Invoices\Domain\Entity\Invoice;
use Illuminate\Database\Eloquent\Model;

/**
 * @property string $id UUID
 * @property string $number invoice number
 * @property string $date invoice issuance date
 * @property string $due_date invoice due date
 * @property string $company
 */
class InvoiceLineModel extends Model
{
    protected $table = 'invoice_product_lines';

    protected $fillable = [
        'invoice_id',
        'product_name',
        'quantity',
        'price',
    ];

    public function invoice()
    {
        return $this->belongsTo(Invoice::class);
    }
}