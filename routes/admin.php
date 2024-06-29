<?php

use App\Http\Controllers\Admin\AddressController;
use Illuminate\Support\Facades\Route;

// Admin Controllers
use App\Http\Controllers\Admin\LoginController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\CityController;
use App\Http\Controllers\Admin\ShipmentController;
use App\Http\Controllers\Admin\ContactController;
use App\Http\Controllers\Admin\DelegateController;
use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\Admin\InvoiceController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\RegionController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\ShipmentImportController;
use App\Http\Controllers\Admin\TransactionController;
use App\Models\Shipment;
// Route::get('/ccccccccccccccccccccccccccccccccccaaaaaaaaa', function(){
//     App\Models\Admin::create([
//         'name'      => 'shipybuy',
//         'email'     => 'info3@shipybuy.com',
//         'phone'     => '01022844255',
//         'email_verified_at' => now(),
//         'password' => bcrypt('admin123+-'),
//         'dark'      => '0',
//     ]);
//     return 'done';
// });

use Illuminate\Support\Facades\App;

// Set the language locale to Arabic
App::setLocale('ar');

Route::prefix('superAdmin/admin/dashboard')->middleware('auth:admin')->name('admin.')->group(function () {
    // Route::get('/tmp', function(){
    //     $sh = Shipment::findOrFail(3);
    //     dd($sh->city);
    // });
    Route::get('/', [HomeController::class, 'index'])->name('dashboard');
    Route::get('/invoice', [InvoiceController::class, 'invoice'])->name('invoice');
    Route::resource('users', UserController::class);
    Route::resource('delegates', DelegateController::class);
    Route::get('get-shipments/{delegate}', [DelegateController::class,'get_shipments'])->name('delegates.get_shipments');
    Route::get('get-delegates-by-city-id/{city}', [DelegateController::class,'get_delegates_by_city_id'])->name('delegates.get_delegates_by_city_id');
    Route::get('get-delegates-by-city-name/{name}', [DelegateController::class,'get_delegates_by_city_name'])->name('delegates.get_delegates_by_city_name');

    Route::post('get-delegate-daily-delivery-statement/{delegate}', [DelegateController::class,'delegate_daily_delivery_statement'])->name('delegates.delegate_daily_delivery_statement');
    Route::post('get-delegate-final-delivery-statement/{delegate}', [DelegateController::class,'delegate_final_delivery_statement'])->name('delegates.delegate_final_delivery_statement');

    Route::post('users/documents/delete/{id}', [UserController::class, 'documents_delete'])->name('users.documents_delete');
    Route::post('users/documents/update/{id}', [UserController::class, 'documents_update'])->name('users.documents_update');
    Route::post('users/payment_methods/delete/{id}', [UserController::class, 'payments_delete'])->name('users.payments_delete');
    // Route::post('users/payment_methods/update/{id}', [UserController::class, 'payments_update'])->name('users.payments_update');
    Route::resource('shipments', ShipmentController::class);
    Route::resource('contacts', ContactController::class);
    Route::resource('orders', OrderController::class);
    Route::resource('admins', AdminController::class);
    Route::resource('transactions', TransactionController::class);
    Route::post('transactions/exportPayment', [TransactionController::class, 'exportPayment'])->name('exportPayment');
    Route::post('/exportTransactions', [TransactionController::class, 'export'])->name('trans.ex');
    Route::get('/indexRequest', [TransactionController::class, 'indexRequest'])->name('requests.index');
    Route::post('/updateRequest/{id}', [TransactionController::class, 'updateRequest'])->name('requests.update');
    Route::resource('cities', CityController::class);
    Route::resource('regions', RegionController::class);

    Route::get('get-shipments-by-status/{status}', [ShipmentController::class, 'get_shipments_by_status'])->name('get_shipments_by_status');
    Route::post('update-shipment-status/{shipment}/{status}', [ShipmentController::class, 'update_status'])->name('update_shipment_status');

    Route::post('assign-delegate', [ShipmentController::class, 'assign_delegate'])->name('assign_delegate');
    Route::post('cancel-assign-delegate/{shipment_id}', [ShipmentController::class, 'cancel_assign_delegate'])->name('shipments.cancel_assign_delegate');
    Route::get('import', [ShipmentController::class, 'import_create'])->name('import.create');
    Route::post('import', [ShipmentController::class, 'import_store'])->name('import.store');
    // Route::get('create', [ShipmentController::class, 'create'])->name('shipment.create');
    // Route::post('store', [ShipmentController::class, 'store'])->name('shipment.store');
    Route::post('export-all-shipments', [ShipmentController::class, 'export'])->name('shipment.export');

    Route::get('import_shipments', [ShipmentImportController::class, 'create'])->name('import_shipments.create');
    Route::post('import_shipments', [ShipmentImportController::class, 'import_store'])->name('import_shipments.store');

    Route::get('cities/rates/{city_id}', [CityController::class, 'rates'])->name('cities.rates');
    Route::post('cities/add_rate', [CityController::class, 'add_rate'])->name('cities.add_rate');
    Route::post('cities/rate_destroy/{id}', [CityController::class, 'rate_destroy'])->name('cities.rate_destroy');
    Route::post('cities/update_rate/{id}', [CityController::class, 'update_rate'])->name('cities.update_rate');

    Route::post('/logout', [HomeController::class ,'logout'])->name('logout');
    Route::post('/mode', [HomeController::class , 'mode'])->name('mode');
    Route::get('/setting', [SettingController::class ,'index'])->name('setting.index');
    Route::post('/setting/update', [SettingController::class , 'update'])->name('setting.update');

    Route::get('/address', [AddressController::class,'index'])->name('address.index');
    // Route::get('/address/create', [AddressController::class,'create'])->name('address.create');
    Route::post('/address/store',[AddressController::class,'store'])->name('address.store');
    Route::get('/address/delete/{id}', [AddressController::class,'delete'])->name('address.delete');
});

// Route::get('', [LoginController::class ,'getLogin']);
Route::group(['prefix' => 'admin' ,'middleware' => 'guest:admin'], function () {
    Route::get('login', [LoginController::class ,'getLogin'])->name('admin.getLogin');
    Route::post('login', [LoginController::class ,'login'])->name('admin.login');
});
