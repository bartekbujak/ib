<?php
declare(strict_types=1);

namespace App\Modules\Invoices\Infrastructure\Database\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;


/**
 * @property string $id UUID
 * @property string $name invoice number
 * @property string $street invoice issuance date
 * @property string $city invoice due date
 * @property string $zip
 * @property string $phone invoice billed company
 * @property string $email status of invoice approval
 */
class CompanyModel extends Model
{
    protected $table = 'companies';
    protected $keyType = 'string';

    public $incrementing = false;
}
