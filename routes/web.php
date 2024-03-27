<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ExpressController;
use App\Http\Controllers\UserDashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ShipmentImportController;
use App\Http\Controllers\TestController;

// Route::post('testupload', [TestController::class, 'store']);

Route::group(
    [
        'prefix' => LaravelLocalization::setLocale(),
        'middleware' => [ 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath' ]
    ],
    function () {
        Route::name('front.')->group(function () {
            Route::get('/', [HomeController::class, 'index'])->name('home');

            Route::post('/sumExpress', [HomeController::class, 'sumExpress'])->name('sumExpress');
            Route::middleware(['guest'])->group(function () {
                Route::get('register', [AuthController::class, 'get_register'])->name('get_register');
                Route::post('register', [AuthController::class, 'register'])->name('register');

                Route::view('forgetPassword', 'pages.auth.forgetPassword')->name('forgetPassword');
                Route::get('login', [AuthController::class, 'get_login'])->name('get_login');
                Route::post('login', [AuthController::class, 'login'])->name('login');
                Route::post('forgetPassword', [AuthController::class, 'forgetPassword'])->name('forgetPassword.post');
                Route::view('forgetPassword/code', 'pages.auth.code')->name('forgetPassword.code');
                Route::post('updatePassword', [AuthController::class, 'updatePassword'])->name('updatePassword');
            });

            // Route::group(function () {
            Route::get('/success', [PaymentController::class, 'success'])->name('success');
            Route::get('/dashboard', [UserDashboardController::class, 'dashboard'])->name('user.dashboard');
            Route::controller(UserDashboardController::class)->prefix('profile')->name('user.')->group(function () {
                Route::get('/account-details', 'account')->name('account');
                Route::get('/local_price', 'localPrice')->name('localPrice');
                Route::post('/account-details/update', 'account_update')->name('account_update');
                // address
                Route::get('/address', 'address')->name('address');
                Route::post('/address/store', 'address_store')->name('address_store');
                Route::get('/address/delete/{id}', 'address_delete')->name('address_delete');

                // documents
                Route::get('/documents', 'documents')->name('documents');
                Route::post('/documents/store', 'documents_store')->name('documents_store');
                Route::get('/documents/delete/{id}', 'documents_delete')->name('documents_delete');
 

                // payment methods
                Route::get('/payment_methods', 'payment_methods')->name('payment_methods');
                Route::post('/payment_method/store', 'payment_method_store')->name('payment_method_store');
                Route::get('/payment_method/delete/{id}', 'payment_method_delete')->name('payment_method_delete');

                // payment methods
                Route::get('/teams', 'teams')->name('teams');
                Route::post('/team/store', 'team_store')->name('team_store');
                Route::get('/team/delete/{id}', 'team_delete')->name('team_delete');

                Route::get('/aramex_account', 'aramex_account')->name('aramex_account');
                Route::post('/aramex_account/update', 'aramex_account_update')->name('aramex_account_update');
            });
            Route::controller(ExpressController::class)->prefix('express')->name('express.')->group(function () {
                Route::get('/', 'index')->name('index');
                Route::get('/trackingPickup', 'trackingPickup')->name('trackingPickup');
                Route::get('/create', 'create')->name('create');
                Route::post('/store', 'store')->name('store');
                Route::post('/edit/{shipment}', 'edit')->name('edit');
                Route::post('/shipment_update', 'shipment_update')->name('shipment_update');
                Route::post('/call_aramex', 'orderAramex')->name('call_aramex');
                Route::get('/show/{id}', 'show')->name('show');
                Route::post('/export', 'export')->name('export');
                Route::post('/printSelectedBulk', 'printSelectedBulk')->name('printSelectedBulk');
                // Route::get('/printSelectedBulk', 'printSelectedBulkGet')->name('printSelectedBulk.get');
                // Route::post('register', [AuthController::class, 'register'])->name('register');
            });
            Route::get('shipments_import', [ShipmentImportController::class, 'create'])->name('get_shipments_import');
            Route::post('shipments_import', [ShipmentImportController::class, 'import_store'])->name('shipments_import');
            Route::controller(PaymentController::class)->prefix('payments')->name('payments.')->group(function () {
                Route::get('/', 'index')->name('index');
                Route::get('/{id}', 'show')->name('show');
                Route::post('/export', 'export')->name('export');
                Route::post('/PaymentRequestSend', 'PaymentRequestSend')->name('PaymentRequestSend');
                Route::post('exportPayment', 'exportPayment')->name('exportPayment');
                Route::post('checked', 'checked')->name('checked');
                // Route::post('/shipment_update', 'shipment_update')->name('shipment_update');
                // Route::get('/{id}', 'show')->name('show');
                // Route::post('register', [AuthController::class, 'register'])->name('register');
            });

            Route::get('logout', function () {
                auth()->logout();
                return redirect()->route('front.home');
            })->name('logout');

            // });

            Route::controller(AuthController::class)->name('confirmAccount.')->group(function () {
                Route::get('codeForm', 'code')->name('getForm');
                Route::post('checkCode', 'check_code')->name('postForm');
            });
            Route::view('contact', 'pages.contact')->name('contact');
            Route::post('contact', [HomeController::class,'contact_post'])->name('contact-post');
        });
    }
);
