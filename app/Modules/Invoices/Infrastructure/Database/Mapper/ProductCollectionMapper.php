<?php
declare(strict_types=1);

namespace App\Modules\Invoices\Infrastructure\Database\Mapper;

use App\Domain\ValueObject\Address;
use App\Domain\ValueObject\Email;
use App\Domain\ValueObject\Phone;
use App\Domain\ValueObject\ZipCode;
use App\Modules\Invoices\Domain\ValueObject\Company;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ProductCollectionMapper
{
    public static function fromArray(HasMany $companyRaw): Company
    {
        $address = new Address(
            $companyRaw['address']['street'],
            $companyRaw['address']['city'],
            new ZipCode($companyRaw['address']['zipCode']),
        );

        return new Company(
            $companyRaw['name'],
            $address,
            new Phone($companyRaw['phone']),
            $companyRaw['email'] ? new Email($companyRaw['email']) : null,
        );
    }


    public static function toArray(Company $company): Company
    {
        return $company->toArray();
    }
}