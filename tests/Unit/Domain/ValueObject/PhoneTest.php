<?php
declare(strict_types=1);

namespace Tests\Unit\Domain\ValueObject;

use App\Domain\ValueObject\Phone;
use InvalidArgumentException;
use Tests\TestCase;

class PhoneTest extends TestCase
{
    public function testValidPhoneNumber()
    {
        $phoneNumber = new Phone('(123) 456-7890');
        $this->assertEquals('(123) 456-7890', (string)$phoneNumber);
    }

    public function testInvalidPhoneNumberFormat()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Invalid phone number format');

        new Phone('123-456-7890');
    }

    public function testInvalidPhoneNumberCharacters()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Invalid phone number format');

        new Phone('(abc) 456-7890');
    }

    public function testInvalidPhoneNumberLength()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Invalid phone number format');

        new Phone('(123) 45-7890');
    }
}
