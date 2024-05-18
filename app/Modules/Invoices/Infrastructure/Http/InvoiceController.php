<?php
declare(strict_types=1);

namespace App\Modules\Invoices\Infrastructure\Http;

use App\Infrastructure\Controller;
use App\Modules\Invoices\Api\InvoiceFacadeInterface;
use Ramsey\Uuid\Uuid;

class InvoiceController extends Controller
{
    public function __construct(private readonly InvoiceFacadeInterface $invoiceFacade) {}

    public function show($id)
    {
        $uuid = Uuid::fromString($id);
        $invoice = $this->invoiceFacade->find($uuid);

        return response()->json($invoice);
    }

    public function approve($id)
    {
        $invoice = Invoice::findOrFail($id);

        if ($this->approvalService->isApprovable($invoice)) {
            $this->approvalService->approve($invoice);
            return response()->json(['message' => 'InvoiceModel approved successfully']);
        } else {
            return response()->json(['message' => 'InvoiceModel cannot be approved'], 400);
        }
    }

    public function reject($id)
    {
        $invoice = Invoice::findOrFail($id);

        if ($this->approvalService->isRejectable($invoice)) {
            $this->approvalService->reject($invoice);
            return response()->json(['message' => 'InvoiceModel rejected successfully']);
        } else {
            return response()->json(['message' => 'InvoiceModel cannot be rejected'], 400);
        }
    }
}