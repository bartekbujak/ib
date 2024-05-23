<?php

use App\Modules\Invoices\Infrastructure\Http\InvoiceController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('invoice')->group(function () {
    Route::get('{id}', [InvoiceController::class, 'show']);
    Route::get('{id}/approve', [InvoiceController::class, 'approve']);
    Route::get('{id}/reject', [InvoiceController::class, 'reject']);
});