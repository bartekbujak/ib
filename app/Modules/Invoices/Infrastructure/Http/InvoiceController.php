<?php
declare(strict_types=1);

namespace App\Modules\Invoices\Infrastructure\Http;

use App\Infrastructure\Controller;
use App\Modules\Invoices\Api\InvoiceFacadeInterface;
use App\Modules\Invoices\Domain\Exception\InvoiceNotExistException;
use Ramsey\Uuid\Uuid;

class InvoiceController extends Controller
{
    public function __construct(private InvoiceFacadeInterface $invoiceFacade) {}

    public function show($id)
    {

        try {
            $uuid = Uuid::fromString($id);
            $invoice = $this->invoiceFacade->find($uuid);
            return response()->json($invoice);
        } catch (InvoiceNotExistException) {
            return response()->json(['message' => 'InvoiceModel does not exist'], 404);
        }
    }

    public function approve($id)
    {
        try {
            $this->invoiceFacade->approve(Uuid::fromString($id));

            return response()->json(['message' => 'InvoiceModel approved successfully']);
        } catch (InvoiceNotExistException) {
           return response()->json(['message' => 'InvoiceModel does not exist'], 404);
        } catch (\Exception) {
            return response()->json(['message' => 'InvoiceModel cannot be approved'], 400);
        }
    }

    public function reject($id)
    {
        try {
            $this->invoiceFacade->reject(Uuid::fromString($id));

            return response()->json(['message' => 'InvoiceModel rejected successfully']);
        } catch (InvoiceNotExistException) {
            return response()->json(['message' => 'InvoiceModel does not exist'], 404);
        } catch (\Exception $e) {
            return response()->json(['message' => 'InvoiceModel cannot be rejected'], 400);
        }
    }
}
