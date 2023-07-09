<?php

use App\Http\Controllers\BrandController;
use App\Http\Controllers\FinanceController;
use App\Http\Controllers\InvoiceListingController;
use App\Http\Controllers\MarketingController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\PurchaseListingController;
use App\Http\Controllers\PurchasingController;
use App\Http\Controllers\StoreController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WarehouseController;
use Illuminate\Support\Facades\Route;

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


Route::get('/', [UserController::class, 'loginView'])->name('loginView');
Route::post('/login', [UserController::class, 'login'])->name('login');
Route::get('/logout', [UserController::class, 'logout'])->name('logout');

Route::group(['prefix'=>'warehouse',  'middleware' => 'warehouse'], function(){
    Route::get('/dashboard', [WarehouseController::class, 'dashboard'])->name('dashboard');

    // IN product
    Route::get('/inbound', [WarehouseController::class, 'inbound'])->name('inbound');
    Route::patch('/inbound/update', [WarehouseController::class, 'updateListing'])->name('inbound.update');
    Route::get('/inbound/{code}', [WarehouseController::class, 'view'])->name('inbound.view');
    Route::get('/inbound/view/process', [WarehouseController::class, 'inboundProcess'])->name('inbound.process');
    
    //  in process product    
    Route::get('/inbound/process/list', [WarehouseController::class, 'process'])->name('process');
    Route::get('/process/view', [WarehouseController::class, 'inboundProcessView'])->name('process.view');
    Route::patch('/process/view', [WarehouseController::class, 'processUpdate'])->name('process.update');
    
    // done product
    Route::get('/done/view', [WarehouseController::class, 'doneList'])->name('done');
    Route::get('/inbound/done/list', [WarehouseController::class, 'inboundDoneList'])->name('done.list');

    // outbound
    Route::get('/outbound', [WarehouseController::class, 'outbound'])->name('outbound');
    Route::get('/outbound/{code}', [WarehouseController::class, 'viewOutbound'])->name('outbound.view');
    Route::get('/outbound/view/process', [WarehouseController::class, 'outboundProcess'])->name('outbound.process');

    //  out process invoice    
    Route::get('/outbound-process', [WarehouseController::class, 'processOutbound'])->name('process.outboundView');
    Route::get('/outbound-process-view', [WarehouseController::class, 'outboundProcessView'])->name('process.outbound');
    Route::patch('/outbound-process-done', [WarehouseController::class, 'outboundDone'])->name('outbound.done');

    // done outbound
    Route::get('/outbound-done', [WarehouseController::class, 'doneListOutbound'])->name('done.outbound');
    Route::get('/outbound-done-list', [WarehouseController::class, 'outboundDoneList'])->name('doneList.outbound');
     


    // Master Product
    Route::get('/product', [ProductController::class, 'index'])->name('product');
    Route::post('/product/create', [ProductController::class, 'create'])->name('product.create');
    Route::get('/product/{id}', [ProductController::class, 'edit'])->name('product.edit');
    Route::post('/product/update', [ProductController::class, 'update'])->name('product.update');

    // Master Supplier
    Route::get('/supplier', [SupplierController::class, 'index'])->name('supplier');
    Route::post('/supplier/create', [SupplierController::class, 'create'])->name('supplier.create');
    Route::get('/supplier/{id}', [SupplierController::class, 'edit'])->name('supplier.edit');
    Route::post('/supplier/update', [SupplierController::class, 'update'])->name('supplier.update');

    // Master Brand
    Route::get('/brand', [BrandController::class, 'index'])->name('brand');
    Route::post('/brand/create', [BrandController::class, 'create'])->name('brand.create');
    Route::get('/brand/{id}', [BrandController::class, 'edit'])->name('brand.edit');
    Route::post('/brand/update', [BrandController::class, 'update'])->name('brand.update');
    
    // Master Brand
    Route::post('/brand', [BrandController::class, 'getByIdSupplier'])->name('brand.getByIdSupplier');






    Route::get('/outbound', [WarehouseController::class, 'outbound'])->name('outbound');
    Route::get('/process', [WarehouseController::class, 'process'])->name('process');
});


Route::group(['prefix'=>'finance',  'middleware' => 'finance'], function(){
    Route::get('/invoice', [FinanceController::class, 'invoice'])->name('invoice');
    Route::post('/invoice/update', [FinanceController::class, 'update'])->name('invoice.update');

    Route::get('/purchase', [FinanceController::class, 'purchase'])->name('finance.purchase');
    Route::post('/purchase/update', [FinanceController::class, 'updatePurchase'])->name('finance.update-purchase');
});


Route::group(['prefix'=>'purchasing',  'middleware' => 'purchasing'], function(){
    // purchase
    Route::get('/purchase', [PurchasingController::class, 'purchase'])->name('purchase');
    Route::post('/add', [PurchasingController::class, 'add'])->name('purchase.add');
    Route::get('/view/{code}', [PurchasingController::class, 'showPo'])->name('purchase.insert');
    Route::get('/views/product', [PurchasingController::class, 'showListings'])->name('purchase.insertProduct');
    Route::post('/views/product', [PurchasingController::class, 'addProduct'])->name('purchase.addProduct');
    Route::patch('/views/product', [PurchasingController::class, 'updatePurchase'])->name('purchase.update');
    
    // purchase listing
    Route::delete('/purchase-listings', [PurchaseListingController::class, 'delete'])->name('purchaseListing.delete');
});


Route::group(['prefix'=>'marketing',  'middleware' => 'marketing'], function(){
    Route::get('/order', [MarketingController::class, 'order'])->name('order');
    Route::post('/add', [MarketingController::class, 'add'])->name('order.add');
    Route::get('/view/{code}', [MarketingController::class, 'showInv'])->name('order.insert');
    Route::get('/views/product', [MarketingController::class, 'showListings'])->name('order.insertProduct');
    Route::post('/views/product', [MarketingController::class, 'addProduct'])->name('order.addProduct');
    Route::patch('/views/product', [MarketingController::class, 'updateInvoice'])->name('order.update');

    // invoice listing
    Route::delete('/order', [InvoiceListingController::class, 'delete'])->name('invoiceListing.delete');
    
    // master store
    Route::get('/store', [StoreController::class, 'index'])->name('store');
    Route::post('/store/create', [StoreController::class, 'create'])->name('store.create');
    Route::get('/store/{id}', [StoreController::class, 'edit'])->name('store.edit');
    Route::post('/store/update', [StoreController::class, 'update'])->name('store.update');

});
