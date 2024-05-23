<?php
declare(strict_types=1);

namespace Tests\Unit\Modules\Invoices\Domain\Entity;

use App\Domain\Enums\StatusEnum;
use App\Domain\ValueObject\Address;
use App\Domain\ValueObject\Email;
use App\Domain\ValueObject\Money;
use App\Domain\ValueObject\Phone;
use App\Domain\ValueObject\ZipCode;
use App\Modules\Approval\Api\ApprovalFacadeInterface;
use App\Modules\Invoices\Domain\Entity\Company;
use App\Modules\Invoices\Domain\Entity\Invoice;
use App\Modules\Invoices\Domain\Entity\Product;
use App\Modules\Invoices\Domain\Entity\ProductLine;
use DateTimeImmutable;
use Ramsey\Uuid\Uuid;
use Tests\TestCase;

class InvoiceTest extends TestCase
{
    public function testInvoiceToArray()
    {
        $invoice = $this->createInvoice();
        [$invoiceId, $companyId, $billedCompanyId, $productId] = $this->getIds();

        $expectedArray = [
            'id' => $invoiceId,
            'invoiceNumber' => 'INV-001',
            'invoiceDate' => '2024-05-23',
            'dueDate' => '2024-06-23',
            'company' => [
                'name' => 'From Company',
                "address" => [
                    "street" => "Test Address 1",
                    "city" => "New York",
                    "zipCode" => "12345",
                ],
                "phone" => "(123) 456-7891",
                "email" => null,
            ],
            'billedCompany' => [
                'name' => 'To Company',
                "address" => [
                    "street" => "Test Address 1",
                    "city" => "New York",
                    "zipCode" => "12345",
                ],
                "phone" => "(123) 456-7890",
                "email" => "noreply@example.com",
            ],
            'status' => StatusEnum::DRAFT->value,
            'lines' => [
                [
                    'id' => $productId,
                    'name' => 'Product A',
                    'price' => '1 usd',
                    'total' => '10 usd',
                ],
            ],
            'total' => '10 usd',
        ];

        $this->assertSame($expectedArray, $invoice->toArray());
    }

    public function testApprove()
    {
        $invoice = $this->createInvoice();
        $approvalFacadeMock = $this->createMock(ApprovalFacadeInterface::class);
        $approvalFacadeMock->expects($this->once())
            ->method('approve')->willReturn(true);
        $invoice->approve($approvalFacadeMock);
        $this->assertEquals(StatusEnum::APPROVED->value, $invoice->toArray()['status']);
    }

    public function testApprovedInvoiceCannotBeApproved()
    {
        $invoice = $this->createInvoice();
        $approvalFacadeMock = $this->createMock(ApprovalFacadeInterface::class);
        $approvalFacadeMock->expects($this->once())
            ->method('approve')
            ->willThrowException(new \LogicException('Approval failed'));
        $this->expectException(\LogicException::class);
        $this->expectExceptionMessage('Approval failed');
        $invoice->approve($approvalFacadeMock);
    }

    public function testReject()
    {
        $invoice = $this->createInvoice();
        $approvalFacadeMock = $this->createMock(ApprovalFacadeInterface::class);
        $approvalFacadeMock->expects($this->once())
            ->method('reject')->willReturn(true);
        $invoice->reject($approvalFacadeMock);
        $this->assertEquals(StatusEnum::REJECTED->value, $invoice->toArray()['status']);
    }

    private function createInvoice(): Invoice
    {
        [$invoiceId, $companyId, $billedCompanyId, $productId] = $this->getIds();
        $address = new Address(
            'Test Address 1',
            'New York',
            new ZipCode('12345'),
        );

        $company = new Company('From Company', $address, new Phone('(123) 456-7891'));
        $billedCompany = new Company('To Company', $address, new Phone('(123) 456-7890'), new Email('noreply@example.com'));
        $product = new Product(Uuid::fromString($productId), 'Product A', new Money(100));
        $invoiceDate = new DateTimeImmutable('2024-05-23');
        $dueDate = new DateTimeImmutable('2024-06-23');
        $productLine = new ProductLine(Uuid::fromString($productId), $product, 10);
        $invoice = new Invoice(Uuid::fromString($invoiceId), 'INV-001', $invoiceDate, $dueDate, $company, $billedCompany);

        $invoice->addProductLine($productLine);

        return $invoice;
    }

    private function getIds(): array
    {
        $companyId = "d9890249-0c08-4757-87ae-92abb526978f";
        $billedCompanyId = "4f00c838-e60d-454f-bf1c-a054db33db34";
        $invoiceId = "24bdbffe-5a67-4040-a3ba-ec081b26eee2";
        $productId = "dc05027a-14f1-4bd8-9fad-d15ec5ac43f1";

        return [$invoiceId, $companyId, $billedCompanyId, $productId];
    }
}