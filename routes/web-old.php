<?php

use App\Http\Middleware\CustomerAuth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\GmeRegController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\CustomerController;
use App\Http\Middleware\LoginAuthMiddleware;
use App\Http\Controllers\AnalyticsController;
use App\Http\Controllers\GmeBusinessController;
use App\Http\Controllers\CustomerAuthController;
use App\Http\Controllers\GmeFormAllUserController;
use App\Http\Controllers\BusinessCategoryController;
use App\Http\Controllers\GmeBusinessAdminController;
use App\Http\Controllers\FrontendGmeBusinessController;





/////////////////////For All///////////////////////
        Route::get('/get-business/form', [GmeFormAllUserController::class, 'getBusinessForm'])->name('get.business');
        Route::get('/get-business/index', [GmeFormAllUserController::class, 'getAllBusiness'])->name('get.business-index');
        Route::get('/get-business/services/{category}', [GmeFormAllUserController::class, 'getServices'])->name('get.business.services');
        Route::post('/add-business/save-step', [GmeFormAllUserController::class, 'saveStep'])->name('add.business.save-step');
        Route::get('/get-business/success', [GmeFormAllUserController::class, 'success'])->name('get.business.success');






// Route::prefix('gme')->name('gme.')->group(function () {
//     Route::get('/business/register', [GmeBusinessController::class, 'showRegister'])->name('business.register');
//     Route::post('/business/save-step', [GmeBusinessController::class, 'saveStep'])->name('business.save-step');
//     Route::get('/business/success', [GmeBusinessController::class, 'success'])->name('business.success');
// });












Route::middleware(['web', 'setLocale'])->group(function () {
    Route::get('/', [AuthController::class, 'showLoginForm']);
    Route::post('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});


Route::middleware(['setLocale'])->group(function () {
    Route::get('/gme-network-login', [CustomerAuthController::class, 'showCustomerLoginForm'])->name('customer.login');
    Route::post('/gme-network-login', [CustomerAuthController::class, 'cusLogin'])->name('customer.login.submit');
    Route::get('/gme-network-register', function () { return view('customer.auth.register');})->name('customer.register');
    Route::post('/register', [CustomerAuthController::class, 'register']);
    
    Route::get('/gme-network-verify-otp-form/{customer}', function ($customerId) {
        return view('customer.auth.verify-reg-otp', compact('customerId'));
    })->name('customer.reg.otp.form');

    Route::post('/verify-reg-otp', [CustomerAuthController::class, 'verifyRegOtp'])->name('customer.reg.otp.verify');
        

    //customer.forget.password.post
    Route::get('/gme-network-forget-password', [CustomerAuthController::class, 'showForgetPasswordForm'])->name('customer.forget.password');
    Route::post('/gme-network-forget-password', [CustomerAuthController::class, 'forgotPassword'])->name('customer.forget.password.post');

    //verifyOtpForm
    Route::get('/gme-network-verify-otp', [CustomerAuthController::class, 'showVerifyOtpForm'])->name('customer.verify.otp');
    Route::post('/gme-network-verify-otp', [CustomerAuthController::class, 'verifyOtp'])->name('customer.verify.otp.post');

    //resetPasswordForm
    Route::get('/gme-network-reset-password', [CustomerAuthController::class, 'showResetPasswordForm'])->name('customer.reset.password');
    Route::post('/gme-network-reset-password', [CustomerAuthController::class, 'resetPassword'])->name('customer.reset.password.post');




    Route::post('/business/save-step', [GmeRegController::class, 'saveStep'])->name('gme.business.save-step');
    Route::get('/business/success', [GmeRegController::class, 'success'])->name('gme.business.success');
    Route::get('/get-services/{category}', [GmeRegController::class, 'getServices'])->name('get.services');

});






// Route::post('/logout', [CustomerAuthController::class, 'logout'])->middleware('auth:customer');
Route::post('/forgot-password', [CustomerAuthController::class, 'forgotPassword']);
Route::post('/verify-otp', [CustomerAuthController::class, 'verifyOtp']);
Route::post('/reset-password', [CustomerAuthController::class, 'resetPassword']);







Route::middleware(['setLocale',CustomerAuth::class,])->group(function () {

        Route::get('/business/register', [GmeRegController::class, 'showRegisterForm'])->name('gme.business.register');
        Route::get('/gme-business-index', [CustomerController::class, 'gmeBusinessIndex'])->name('customer.gme-business-form.index');
            //For Customer Own
        Route::get('/business-index', [GmeRegController::class, 'businessIndexCustomer'])->name('customer.business-form.index');

    Route::get('/customer/dashboard', [CustomerAuthController::class, 'customerDashboard'])->name('customer.dashboard');
    Route::get('/customer/logout', [CustomerAuthController::class, 'cusLogout'])->name('customer.logout');


    Route::get('/customer/profile', [CustomerController::class, 'customerProfile'])->name('customer.profile');
    Route::put('/customer/profile', [CustomerController::class, 'updateProfile'])->name('customer.profile.update');

    Route::get('/update-password', [CustomerController::class, 'updatePassword'])->name('customer.updatePassword');
    Route::post('/update-password', [CustomerController::class, 'storeUpdatePassword'])->name('customer.storeUpdatePassword');


    // Route::get('/gme-business-form', [CustomerController::class, 'createGmeBusinessForm'])->name('customer.gme-business-form.create');

    // Route::get('/gme-business-form/{business}', [CustomerController::class, 'show'])->name('customer.gme-business-form.show');









});




Route::get('/make-hash/{string}', function ($string) {
    return response()->json([
        'original' => $string,
        'hash' => bcrypt($string),
    ]);
});

Route::middleware([
    'setLocale',
    LoginAuthMiddleware::class,
])->group(function () {




    // Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard.index');
    // Route::get('/gme-business/create', [GmeBusinessController::class, 'create'])->name('gme-business.create');
    // Route::post('/gme-business/store', [GmeBusinessController::class, 'store'])->name('gme-business.store');
    // Route::get('/gme-business', [GmeBusinessController::class, 'index'])->name('gme-business.index');

    Route::resource('business-categories', BusinessCategoryController::class);
    Route::resource('services', ServiceController::class);

    



    Route::resource('gme-business', FrontendGmeBusinessController::class);

    Route::resource('gme-business-admin', GmeBusinessAdminController::class);




    Route::group(['prefix' => 'roles'], function () {
        Route::get('/', [RoleController::class, 'index'])->name('role.list');
        Route::get('/create', [RoleController::class, 'create'])->name('role.create');
        Route::post('/store', [RoleController::class, 'store'])->name('role.store');
        Route::get('/edit/{id}', [RoleController::class, 'edit'])->name('role.edit');
        Route::post('/update/{id}', [RoleController::class, 'update'])->name('role.update');
        Route::get('/delete/{id}', [RoleController::class, 'delete'])->name('role.delete');
    });

    Route::group(['prefix' => 'reports'], function () {
        Route::get('/analytics', [AnalyticsController::class, 'index'])->name('reports.analytics');
        Route::get('/export-csv', [AnalyticsController::class, 'exportCsv'])->name('reports.export.csv');
        Route::get('/export-xlsx', [AnalyticsController::class, 'exportXlsx'])->name('reports.export.xlsx');
        Route::get('/export-pdf', [AnalyticsController::class, 'exportPdf'])->name('reports.export.pdf');

        // Route::get('/analytics', [AnalyticsController::class, 'index'])->name('reports.index');
        Route::get('/data', [AnalyticsController::class, 'fetchData'])->name('reports.data');
    });


    Route::get('/notifications/latest', [AdminController::class, 'latestNotifications']);
    Route::post('/notifications/read/{id}', [AdminController::class, 'markAsRead']);

    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    // Route::get('/dashboard/chart-data', [AdminController::class, 'dashboard'])->name('admin.dashboard.chartData');
    Route::get('/admin/dashboard/chart-data', [AdminController::class, 'chartData'])->name('admin.dashboard.chartData');

    Route::get('/stock-entry-chart', [AdminController::class, 'stockEntryChart'])
        ->name('dashboard.stockEntryChart');

    Route::get('/stock-out-chart', [AdminController::class, 'stockOutChart'])
        ->name('dashboard.stockOutChart');

    Route::get('/stock-in-out-chart', [AdminController::class, 'stockInOutChart'])
        ->name('dashboard.stockInOutChart');

    Route::get('/purchase-and-requisition-chart', [AdminController::class, 'purchaseRequisitionChart'])
        ->name('dashboard.purchaseRequisitionChart');




    
    Route::group(['prefix' => 'user'], function () {

        // Route::resource('user', UserController::class);
        Route::get('/', [UserController::class, 'index'])->name('user.index');
        Route::get('/create', [UserController::class, 'create'])->name('user.create');
        Route::post('/store', [UserController::class, 'store'])->name('user.store');
        Route::get('/edit/{user}', [UserController::class, 'edit'])->name('user.edit');
        Route::post('/update/{user}', [UserController::class, 'update'])->name('user.update');
        // Route::delete('/delete/{user}', [UserController::class, 'destroy'])->name('user.destroy');

        // Route::get('settings', [UserController::class, 'userSettings'])->name('users.settings');
        Route::post('store/settings', [UserController::class, 'updateUserSettings'])->name('user.store-settings');
        Route::get('profile/update', [UserController::class, 'userProfileUpdate'])->name('user.profileUpdate');
        Route::post('profile/update', [UserController::class, 'storeUserProfileUpdate'])->name('user.profileUpdate');

        Route::get('/change-password', [UserController::class, 'changePassword'])->name('user.changePassword');
        Route::post('/change-password', [UserController::class, 'storeChangePassword'])->name('user.changePassword');
        Route::get('/settings', [UserController::class, 'userSettings'])->name('user.settings');
    });




});