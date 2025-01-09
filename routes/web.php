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
use App\Http\Controllers\EmailController;
use App\Http\Controllers\IndentController;
use App\Http\Controllers\NantongShipmentController;
use App\Http\Controllers\OfferController;
use App\Http\Controllers\ProformaInvoiceController;
use App\Http\Controllers\PurchaseOrderController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\ShadeCardController;
use App\Http\Controllers\ShipmentController;
use App\Http\Controllers\SizeController;
use App\Http\Controllers\WarrantyNoteController;


Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login');

Route::middleware('auth')->group(function () {
    Route::get('/', [UserController::class, 'dashboard'])->name('main');
    Route::get('dashboard', [UserController::class, 'dashboard'])->name('dashboard');
    Route::get('/db-backup', [UserController::class, 'db_backup'])->name('db_backup');
    Route::get('/logout', [LoginController::class, 'logout'])->name('logout');

    // Users
    Route::get('users', [UserController::class, 'users'])->name('user');
    Route::get('user/create', [UserController::class, 'create'])->name('user.create');
    Route::get('user/edit/{id}', [UserController::class, 'edit'])->name('user.edit');
    Route::get('user/delete/{id}', [UserController::class, 'delete'])->name('user.delete');
    Route::post('user/store', [UserController::class, 'store'])->name('user.store');
    Route::post('user/update', [UserController::class, 'update'])->name('user.update');

    // Role Work
    Route::get('roles', [RoleController::class, 'index'])->name('role');
    Route::get('role/create', [RoleController::class, 'create'])->name('role.create');
    Route::post('role/create/form', [RoleController::class, 'store'])->name('role.create.form');
    Route::get('role/edit/{id}', [RoleController::class, 'edit'])->name('role.edit');
    Route::post('role/edit/form', [RoleController::class, 'update'])->name('role.edit.form');
    Route::get('role/delete/{id}', [RoleController::class, 'delete'])->name('role.delete');

    // USER ACCESS WORK
    Route::get('permissions/{id}', [UserController::class, 'permissions'])->name('permissions');
    Route::post('add_permissions', [UserController::class, 'add_permissions'])->name('add_permissions');

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
    Route::get('customer/products', [CustomerController::class, 'customer_product'])->name('customer.customer_product');

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
    Route::get('supplier/products', [SupplierController::class, 'supplier_product'])->name('supplier.supplier_product');

    // Products
    Route::get('products', [ProductController::class, 'index'])->name('product');
    Route::get('product/create', [ProductController::class, 'create'])->name('product.create');
    Route::get('product/get', [ProductController::class, 'get'])->name('product.get');
    Route::get('product/edit/{id}', [ProductController::class, 'edit'])->name('product.edit');
    Route::get('product/delete/{id}', [ProductController::class, 'delete'])->name('product.delete');
    Route::post('product/store', [ProductController::class, 'store'])->name('product.store');
    Route::post('product/update', [ProductController::class, 'update'])->name('product.update');
    Route::get('product/map', [ProductController::class, 'map'])->name('product.map');
    Route::post('product/map', [ProductController::class, 'map_product'])->name('product.map_product');

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
    Route::get('inquiry/view/{id}', [InquiryController::class, 'view'])->name('inquiry.view');
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
    Route::get('po/view/{id}', [PurchaseOrderController::class, 'view'])->name('po.view');
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
    Route::get('/report/supplier-product', [ReportController::class, 'supplier_product'])->name('report.supplier_product');
    Route::get('/report/customer-product', [ReportController::class, 'customer_product'])->name('report.customer_product');
    Route::get('/report/inquiry', [ReportController::class, 'inquiry'])->name('report.inquiry');
    Route::get('/report/offer', [ReportController::class, 'offer'])->name('report.offer');
    Route::get('/report/po', [ReportController::class, 'po'])->name('report.po');
    Route::get('/report/indent', [ReportController::class, 'indent'])->name('report.indent');
    Route::get('/report/shipment', [ReportController::class, 'shipment'])->name('report.shipment');
    Route::get('/report/shade-cards', [ReportController::class, 'shade_card'])->name('report.shade_card');
    Route::get('/report/proforma-invoice', [ReportController::class, 'proforma_invoice'])->name('report.proforma_invoice');

    // Shipment
    Route::get('shipments', [ShipmentController::class, 'index'])->name('shipment');
    Route::get('shipment/create', [ShipmentController::class, 'create'])->name('shipment.create');
    Route::get('shipment/edit/{id}', [ShipmentController::class, 'edit'])->name('shipment.edit');
    Route::get('shipment/view/{id}', [ShipmentController::class, 'view'])->name('shipment.view');
    Route::get('shipment/delete/{id}', [ShipmentController::class, 'delete'])->name('shipment.delete');
    Route::post('shipment/store', [ShipmentController::class, 'store'])->name('shipment.store');
    Route::post('shipment/update', [ShipmentController::class, 'update'])->name('shipment.update');

    // Email Setting
    Route::get('email/setting', [EmailController::class, 'emailSetting'])->name('email.setting');
    Route::post('email/setting', [EmailController::class, 'emailSettingUpdate'])->name('email.setting');
    Route::get('email/history', [EmailController::class, 'emailHistory'])->name('email.history');
    Route::get('email/history/{id}', [EmailController::class, 'emailHistoryView'])->name('email.history.view');
    Route::post('email/send-test-mail', [EmailController::class, 'sendTestMail'])->name('email.sendTestMail');
    Route::get('email/inquiry/{id}', [EmailController::class, 'emailInquiry'])->name('email.inquiry');

    // Sizes
    Route::get('sizes', [SizeController::class, 'index'])->name('size');
    Route::get('size/create', [SizeController::class, 'create'])->name('size.create');
    Route::get('size/edit/{id}', [SizeController::class, 'edit'])->name('size.edit');
    Route::get('size/view/{id}', [SizeController::class, 'view'])->name('size.view');
    Route::get('size/delete/{id}', [SizeController::class, 'delete'])->name('size.delete');
    Route::post('size/store', [SizeController::class, 'store'])->name('size.store');
    Route::post('size/update', [SizeController::class, 'update'])->name('size.update');

    // Shade Card & Artwork
    Route::get('shade-cards', [ShadeCardController::class, 'index'])->name('shade_card');
    Route::get('shade-card/search', [ShadeCardController::class, 'search'])->name('shade_card.search');
    Route::get('shade-card/create', [ShadeCardController::class, 'create'])->name('shade_card.create');
    Route::get('shade-card/edit/{id}', [ShadeCardController::class, 'edit'])->name('shade_card.edit');
    Route::get('shade-card/view/{id}', [ShadeCardController::class, 'view'])->name('shade_card.view');
    Route::get('shade-card/delete/{id}', [ShadeCardController::class, 'delete'])->name('shade_card.delete');
    Route::post('shade-card/store', [ShadeCardController::class, 'store'])->name('shade_card.store');
    Route::post('shade-card/update', [ShadeCardController::class, 'update'])->name('shade_card.update');

    // Proforma Invoice
    Route::get('proforma-invoices', [ProformaInvoiceController::class, 'index'])->name('proforma_invoice');
    Route::get('proforma-invoice/search', [ProformaInvoiceController::class, 'search'])->name('proforma_invoice.search');
    Route::get('proforma-invoice/create', [ProformaInvoiceController::class, 'create'])->name('proforma_invoice.create');
    Route::get('proforma-invoice/edit/{id}', [ProformaInvoiceController::class, 'edit'])->name('proforma_invoice.edit');
    Route::get('proforma-invoice/view/{id}', [ProformaInvoiceController::class, 'view'])->name('proforma_invoice.view');
    Route::get('proforma-invoice/delete/{id}', [ProformaInvoiceController::class, 'delete'])->name('proforma_invoice.delete');
    Route::post('proforma-invoice/store', [ProformaInvoiceController::class, 'store'])->name('proforma_invoice.store');
    Route::post('proforma-invoice/update', [ProformaInvoiceController::class, 'update'])->name('proforma_invoice.update');

    // Nantong Shipment
    Route::get('nantong-shipments', [NantongShipmentController::class, 'index'])->name('nantong_shipment');
    Route::get('nantong-shipment/create', [NantongShipmentController::class, 'create'])->name('nantong_shipment.create');
    Route::get('nantong-shipment/edit/{id}', [NantongShipmentController::class, 'edit'])->name('nantong_shipment.edit');
    Route::get('nantong-shipment/view/{id}', [NantongShipmentController::class, 'view'])->name('nantong_shipment.view');
    Route::get('nantong-shipment/delete/{id}', [NantongShipmentController::class, 'delete'])->name('nantong_shipment.delete');
    Route::post('nantong-shipment/store', [NantongShipmentController::class, 'store'])->name('nantong_shipment.store');
    Route::post('nantong-shipment/update', [NantongShipmentController::class, 'update'])->name('nantong_shipment.update');
});
