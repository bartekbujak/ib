<?php
declare(strict_types=1);

namespace Tests\Unit\Domain\ValueObject;

use App\Domain\ValueObject\ZipCode;
use InvalidArgumentException;
use Tests\TestCase;

class ZipCodeTest extends TestCase
{
    public function testValidZipCodeWithoutExtension()
    {
        $zipCode = new ZipCode('12345');
        $this->assertEquals('12345', (string)$zipCode);
    }

    public function testValidZipCodeWithExtension()
    {
        $zipCode = new ZipCode('12345-6789');
        $this->assertEquals('12345-6789', (string)$zipCode);
    }

    public function testInvalidZipCodeFormat()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Invalid ZIP code format');

        new ZipCode('1234');
    }

    public function testInvalidZipCodeCharacters()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Invalid ZIP code format');

        new ZipCode('12AB4');
    }
}