<?php
declare(strict_types=1);

namespace App\Modules\Invoices\Infrastructure\Database\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;


/**
 * @property string $id UUID
 * @property string $name invoice number
 * @property string $price invoice issuance date
 * @property string $currency invoice due date
 */
class ProductModel extends Model
{
    protected $table = 'products';
    protected $keyType = 'string';

    public $incrementing = false;

    public function invoiceLines(): HasMany
    {
        return $this->hasMany(InvoiceLineModel::class, 'product_id');
    }
}
