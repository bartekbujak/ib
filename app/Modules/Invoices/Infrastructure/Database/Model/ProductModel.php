<?php
declare(strict_types=1);

namespace App\Modules\Invoices\Infrastructure\Database\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;


/**
 * @property string $id UUID
 * @property string $name name
 * @property string $price price
 * @property string $currency currency
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
