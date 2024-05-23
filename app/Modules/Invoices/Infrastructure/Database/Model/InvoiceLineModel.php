<?php
declare(strict_types=1);

namespace App\Modules\Invoices\Infrastructure\Database\Model;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property string $id UUID
 */
class InvoiceLineModel extends Model
{
    protected $table = 'invoice_product_lines';
    protected $keyType = 'string';

    public $incrementing = false;

    protected $fillable = [
        'invoice_id',
        'product_name',
        'quantity',
        'price',
    ];

    public function invoice(): BelongsTo
    {
        return $this->belongsTo(InvoiceModel::class, 'invoice_id');
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(ProductModel::class, 'product_id');
    }
}
