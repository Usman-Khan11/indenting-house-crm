<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\NoteController;
use App\Http\Controllers\InquiryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\QuotationController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\PaymentNoteController;
use App\Http\Controllers\DeliveryNoteController;
use App\Http\Controllers\IndentController;
use App\Http\Controllers\OfferController;
use App\Http\Controllers\PurchaseOrderController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\WarrantyNoteController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login');

Route::middleware('auth')->group(function () {
    Route::get('/', [UserController::class, 'dashboard'])->name('main');
    Route::get('dashboard', [UserController::class, 'dashboard'])->name('dashboard');
    Route::get('/logout', [LoginController::class, 'logout'])->name('logout');

    // Customer
    Route::get('customers', [CustomerController::class, 'index'])->name('customer');
    Route::get('customer/create', [CustomerController::class, 'create'])->name('customer.create');
    Route::get('customer/edit/{id}', [CustomerController::class, 'edit'])->name('customer.edit');
    Route::get('customer/view/{id}', [CustomerController::class, 'view'])->name('customer.view');
    Route::get('customer/delete/{id}', [CustomerController::class, 'delete'])->name('customer.delete');
    Route::post('customer/store', [CustomerController::class, 'store'])->name('customer.store');
    Route::post('customer/update', [CustomerController::class, 'update'])->name('customer.update');
    Route::get('customer/map', [CustomerController::class, 'map'])->name('customer.map');
    Route::post('customer/map', [CustomerController::class, 'map_product'])->name('customer.map_product');

    // Supplier
    Route::get('suppliers', [SupplierController::class, 'index'])->name('supplier');
    Route::get('supplier/create', [SupplierController::class, 'create'])->name('supplier.create');
    Route::get('supplier/edit/{id}', [SupplierController::class, 'edit'])->name('supplier.edit');
    Route::get('supplier/view/{id}', [SupplierController::class, 'view'])->name('supplier.view');
    Route::get('supplier/delete/{id}', [SupplierController::class, 'delete'])->name('supplier.delete');
    Route::post('supplier/store', [SupplierController::class, 'store'])->name('supplier.store');
    Route::post('supplier/update', [SupplierController::class, 'update'])->name('supplier.update');
    Route::get('supplier/map', [SupplierController::class, 'map'])->name('supplier.map');
    Route::post('supplier/map', [SupplierController::class, 'map_product'])->name('supplier.map_product');

    // Products
    Route::get('products', [ProductController::class, 'index'])->name('product');
    Route::get('product/create', [ProductController::class, 'create'])->name('product.create');
    Route::get('product/edit/{id}', [ProductController::class, 'edit'])->name('product.edit');
    Route::get('product/delete/{id}', [ProductController::class, 'delete'])->name('product.delete');
    Route::post('product/store', [ProductController::class, 'store'])->name('product.store');
    Route::post('product/update', [ProductController::class, 'update'])->name('product.update');

    // Services
    Route::get('services', [ServiceController::class, 'index'])->name('service');
    Route::get('service/create', [ServiceController::class, 'create'])->name('service.create');
    Route::get('service/edit/{id}', [ServiceController::class, 'edit'])->name('service.edit');
    Route::get('service/delete/{id}', [ServiceController::class, 'delete'])->name('service.delete');
    Route::post('service/store', [ServiceController::class, 'store'])->name('service.store');
    Route::post('service/update', [ServiceController::class, 'update'])->name('service.update');

    // Notes
    Route::get('notes', [NoteController::class, 'index'])->name('note');
    Route::get('note/create', [NoteController::class, 'create'])->name('note.create');
    Route::get('note/edit/{id}', [NoteController::class, 'edit'])->name('note.edit');
    Route::get('note/delete/{id}', [NoteController::class, 'delete'])->name('note.delete');
    Route::post('note/store', [NoteController::class, 'store'])->name('note.store');
    Route::post('note/update', [NoteController::class, 'update'])->name('note.update');

    // Delivery Notes
    Route::get('delivery-notes', [DeliveryNoteController::class, 'index'])->name('delivery_note');
    Route::get('delivery-note/create', [DeliveryNoteController::class, 'create'])->name('delivery_note.create');
    Route::get('delivery-note/edit/{id}', [DeliveryNoteController::class, 'edit'])->name('delivery_note.edit');
    Route::get('delivery-note/delete/{id}', [DeliveryNoteController::class, 'delete'])->name('delivery_note.delete');
    Route::post('delivery-note/store', [DeliveryNoteController::class, 'store'])->name('delivery_note.store');
    Route::post('delivery-note/update', [DeliveryNoteController::class, 'update'])->name('delivery_note.update');

    // Payment Notes
    Route::get('payment-notes', [PaymentNoteController::class, 'index'])->name('payment_note');
    Route::get('payment-note/create', [PaymentNoteController::class, 'create'])->name('payment_note.create');
    Route::get('payment-note/edit/{id}', [PaymentNoteController::class, 'edit'])->name('payment_note.edit');
    Route::get('payment-note/delete/{id}', [PaymentNoteController::class, 'delete'])->name('payment_note.delete');
    Route::post('payment-note/store', [PaymentNoteController::class, 'store'])->name('payment_note.store');
    Route::post('payment-note/update', [PaymentNoteController::class, 'update'])->name('payment_note.update');

    // Warranty Notes
    Route::get('warranty-notes', [WarrantyNoteController::class, 'index'])->name('warranty_note');
    Route::get('warranty-note/create', [WarrantyNoteController::class, 'create'])->name('warranty_note.create');
    Route::get('warranty-note/edit/{id}', [WarrantyNoteController::class, 'edit'])->name('warranty_note.edit');
    Route::get('warranty-note/delete/{id}', [WarrantyNoteController::class, 'delete'])->name('warranty_note.delete');
    Route::post('warranty-note/store', [WarrantyNoteController::class, 'store'])->name('warranty_note.store');
    Route::post('warranty-note/update', [WarrantyNoteController::class, 'update'])->name('warranty_note.update');

    // Quotation
    Route::get('quotations', [QuotationController::class, 'index'])->name('quotation');
    Route::get('quotation/create', [QuotationController::class, 'create'])->name('quotation.create');
    Route::get('quotation/edit/{id}', [QuotationController::class, 'edit'])->name('quotation.edit');
    Route::get('quotation/delete/{id}', [QuotationController::class, 'delete'])->name('quotation.delete');
    Route::post('quotation/store', [QuotationController::class, 'store'])->name('quotation.store');
    Route::post('quotation/update', [QuotationController::class, 'update'])->name('quotation.update');

    // Inquiry
    Route::get('inquiry', [InquiryController::class, 'index'])->name('inquiry');
    Route::get('inquiry/create', [InquiryController::class, 'create'])->name('inquiry.create');
    Route::get('inquiry/edit/{id}', [InquiryController::class, 'edit'])->name('inquiry.edit');
    Route::get('inquiry/delete/{id}', [InquiryController::class, 'delete'])->name('inquiry.delete');
    Route::post('inquiry/store', [InquiryController::class, 'store'])->name('inquiry.store');
    Route::post('inquiry/update', [InquiryController::class, 'update'])->name('inquiry.update');

    // Offer
    Route::get('offers', [OfferController::class, 'index'])->name('offer');
    Route::get('offer/create', [OfferController::class, 'create'])->name('offer.create');
    Route::get('offer/edit/{id}', [OfferController::class, 'edit'])->name('offer.edit');
    Route::get('offer/view/{id}', [OfferController::class, 'view'])->name('offer.view');
    Route::get('offer/delete/{id}', [OfferController::class, 'delete'])->name('offer.delete');
    Route::post('offer/store', [OfferController::class, 'store'])->name('offer.store');
    Route::post('offer/update', [OfferController::class, 'update'])->name('offer.update');

    // Purchase Order
    Route::get('po', [PurchaseOrderController::class, 'index'])->name('po');
    Route::get('po/create', [PurchaseOrderController::class, 'create'])->name('po.create');
    Route::get('po/edit/{id}', [PurchaseOrderController::class, 'edit'])->name('po.edit');
    Route::get('po/delete/{id}', [PurchaseOrderController::class, 'delete'])->name('po.delete');
    Route::post('po/store', [PurchaseOrderController::class, 'store'])->name('po.store');
    Route::post('po/update', [PurchaseOrderController::class, 'update'])->name('po.update');

    // Indent
    Route::get('indents', [IndentController::class, 'index'])->name('indent');
    Route::get('indent/create', [IndentController::class, 'create'])->name('indent.create');
    Route::get('indent/edit/{id}', [IndentController::class, 'edit'])->name('indent.edit');
    Route::get('indent/view/{id}', [IndentController::class, 'view'])->name('indent.view');
    Route::get('indent/delete/{id}', [IndentController::class, 'delete'])->name('indent.delete');
    Route::post('indent/store', [IndentController::class, 'store'])->name('indent.store');
    Route::post('indent/update', [IndentController::class, 'update'])->name('indent.update');

    // Reports
    Route::get('/report/supplier', [ReportController::class, 'supplier'])->name('report.supplier');
    Route::get('/report/customer', [ReportController::class, 'customer'])->name('report.customer');
    Route::get('/report/product', [ReportController::class, 'product'])->name('report.product');
});
