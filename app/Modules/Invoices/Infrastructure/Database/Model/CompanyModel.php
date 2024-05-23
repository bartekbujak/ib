<?php
declare(strict_types=1);

namespace App\Modules\Invoices\Infrastructure\Database\Model;

use Illuminate\Database\Eloquent\Model;


/**
 * @property string $id UUID
 * @property string $name name
 * @property string $street street
 * @property string $city city
 * @property string $zip
 * @property string $phone phone
 * @property string $email email
 */
class CompanyModel extends Model
{
    protected $table = 'companies';
    protected $keyType = 'string';

    public $incrementing = false;
}
