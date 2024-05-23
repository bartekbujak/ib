<?php
declare(strict_types=1);

namespace App\Modules\Invoices\Infrastructure\Database\Mapper;

use App\Domain\ValueObject\Address;
use App\Domain\ValueObject\Email;
use App\Domain\ValueObject\Phone;
use App\Domain\ValueObject\ZipCode;
use App\Modules\Invoices\Domain\Entity\Company;
use App\Modules\Invoices\Infrastructure\Database\Model\CompanyModel;

class CompanyMapper
{
    public static function fromModel(CompanyModel $model): Company
    {
        $address = new Address(
            $model->street,
            $model->city,
            new ZipCode($model->zip),
        );

        return new Company(
            $model->name,
            $address,
            new Phone($model->phone),
            $model->email ? new Email($model->email) : null,
        );
    }


    public static function toArray(Company $company): array
    {
        return $company->toArray();
    }
}
