<?php

use App\Http\Middleware\CustomerAuth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\DonorController;
use App\Http\Controllers\GuestController;
use App\Http\Controllers\CrisisController;
use App\Http\Controllers\GmeRegController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DonationController;
use App\Http\Middleware\LoginAuthMiddleware;
use App\Http\Controllers\AnalyticsController;
use App\Http\Controllers\ReportPdfController;
use App\Http\Controllers\CrisisViewController;
use App\Http\Controllers\HelpseekerController;
use App\Http\Controllers\GmeBusinessController;
use App\Http\Controllers\CustomerAuthController;
use App\Http\Controllers\HelpseekerPostController;
use App\Http\Controllers\BusinessCategoryController;
use App\Http\Controllers\GmeBusinessAdminController;
use App\Http\Controllers\SslCommerzPaymentController;
use App\Http\Controllers\FrontendGmeBusinessController;
use App\Http\Controllers\HelpseekerPostReportController;




Route::get('/payment/ssl/pay/{donation}', [SslCommerzPaymentController::class, 'pay'])
    ->name('payment.ssl.pay');

// User redirects
Route::get('/payment/ssl/success', [SslCommerzPaymentController::class, 'success']);
Route::get('/payment/ssl/fail', [SslCommerzPaymentController::class, 'fail']);
Route::get('/payment/ssl/cancel', [SslCommerzPaymentController::class, 'cancel']);

// IPN / Server POST callbacks
Route::post('/payment/ssl/success-ipn', [SslCommerzPaymentController::class, 'successIpn']);
Route::post('/payment/ssl/fail-ipn', [SslCommerzPaymentController::class, 'failIpn']);
Route::post('/payment/ssl/cancel-ipn', [SslCommerzPaymentController::class, 'cancelIpn']);










// FRONTEND
Route::get('/', [CrisisViewController::class, 'frontend'])->name('frontend.view');
Route::get('/crisis-list', [CrisisViewController::class, 'index'])->name('crisis.list');
Route::get('/crisis/{id}', [CrisisViewController::class, 'show'])->name('crisis.show');
//store donation
Route::post('/crisis/{id}/donate', [CrisisViewController::class, 'donate'])->name('crisis.donate');
//Donation Amount
Route::post('/donation/store', [DonationController::class, 'store'])->name('donation.store');

//helppostStore
Route::post('/donation/helppost/store', [DonationController::class, 'helppostStore'])->name('helpseeker.posts.donate');


//helpseeker.posts.public
Route::get('/help-seeker/posts', [HelpseekerPostController::class, 'publicIndex'])->name('helpseeker.posts.public');
//make this <a href="{{ route('helpseeker.posts.show', $post->id) }}"
Route::get('/help-seeker/posts/{post}', [HelpseekerPostController::class, 'show'])->name('helpseeker.posts.show');
//donation.store.helpseeker
// Route::post('/help-seeker/posts/{post}/donate', [HelpseekerPostController::class, 'helpDonate'])->name('helpseeker.posts.donate');
// Donor Auth
Route::get('/donor/register', [DonorController::class, 'register'])->name('donor.register');
Route::post('/donor/register', [DonorController::class, 'store'])->name('donor.store');



Route::get('/donor/login', [DonorController::class, 'login'])->name('donor.login');
Route::post('/donor/login', [DonorController::class, 'authenticate'])->name('donor.authenticate');

// Route::post('/donor/logout', [DonorController::class, 'logout'])->name('donor.logout');

Route::middleware('auth:donor')->group(function () {
    
    // Profile page
    Route::get('/donor/profile', [DonorController::class, 'profile'])
        ->name('donor.profile');
    //update
    Route::put('/donor/profile', [DonorController::class, 'updateProfile'])
        ->name('donor.update');

    //Donor all donations list view table
    Route::get('/donor/donations', [DonorController::class, 'donations'])->name('donor.donations');
    // Route::get('/donor/success', [DonationController::class, 'paymentSuccess'])->name('payment.success');

    // Logout
    Route::post('/donor/logout', [DonorController::class, 'logout'])
        ->name('donor.logout');

    Route::get('/donor/donations/print', [DonorController::class, 'printDonations'])
    ->name('donor.donations.print');
    Route::get('/donations/print-help', [DonorController::class, 'printHelpPostDonations'])
    ->name('donor.donations.print.help');

});





        Route::get('/helpseeker/register', [HelpseekerController::class, 'showRegisterForm'])->name('helpseeker.register');
        Route::post('/helpseeker/register', [HelpseekerController::class, 'register'])->name('helpseeker.store');

        Route::get('/helpseeker/login', [HelpseekerController::class, 'showLoginForm'])->name('helpseeker.login');
        Route::post('/helpseeker/login', [HelpseekerController::class, 'login'])->name('helpseeker.authenticate');
// Authenticated Helpseeker Routes
    Route::middleware('auth:helpseeker')->group(function () {
        Route::get('/helpseeker/dashboard', [HelpseekerController::class, 'dashboard'])->name('helpseeker.dashboard');
        Route::get('/helpseeker/logout', [HelpseekerController::class, 'logout'])->name('helpseeker.logout');
        Route::get('/helpseeker/profile', [HelpseekerController::class, 'profile'])->name('helpseeker.profile.edit');
        Route::put('/helpseeker/profile', [HelpseekerController::class, 'profileUpdate'])->name('helpseeker.profile.update');
    
        Route::get('posts', [HelpseekerPostController::class, 'index'])->name('helpseeker.posts.index');
        Route::get('posts/{post}/donations', [HelpseekerPostController::class, 'donations'])->name('helpseeker.posts.donations');
        Route::get('posts/{post}/donations/print', [HelpseekerPostController::class, 'printDonations'])->name('helpseeker.posts.donations.print');




        // Separate create page
        Route::get('posts/create', [HelpseekerPostController::class, 'create'])->name('helpseeker.posts.create');
        Route::post('posts', [HelpseekerPostController::class, 'store'])->name('helpseeker.posts.store');

        // Separate edit page
        Route::get('posts/{post}/edit', [HelpseekerPostController::class, 'edit'])->name('helpseeker.posts.edit');
        Route::put('posts/{post}', [HelpseekerPostController::class, 'update'])->name('helpseeker.posts.update');

        // Separate delete confirmation page
        Route::get('posts/{post}/delete', [HelpseekerPostController::class, 'delete'])->name('helpseeker.posts.delete');
        Route::delete('posts/{post}', [HelpseekerPostController::class, 'destroy'])->name('helpseeker.posts.destroy');

    
        });





Route::middleware([
    'setLocale',
    LoginAuthMiddleware::class,
])->group(function () {



    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/crises/report', [CrisisController::class, 'crisisAnalytics'])->name('crises.analytics');
    Route::get('/crises/analytics/{crisis}', [CrisisController::class, 'crisisAnalyticsDetails'])->name('crises.analytics.details');
    Route::get('/crises/donor-report', [CrisisController::class, 'donorReport'])->name('crises.donor.report');
    Route::get('/crises/donor-report/{donor}', [CrisisController::class, 'donorReportDetails'])->name('crises.donor.report.details');

    Route::get('/reports/crisis/{crisis}/print', [ReportPdfController::class, 'crisisReport'])
    ->name('reports.crisis.print');

    Route::get('/reports/donor/{donor}/print', [ReportPdfController::class, 'donorReport'])
    ->name('reports.donor.print');

    Route::resource('categories', CategoryController::class);
    Route::resource('crises', CrisisController::class);
    //show crises analytics

    // show showHelpseekerPosts index
    Route::get('/helpseekerposts', [AdminController::class, 'showHelpseekerPosts'])->name('admin.helpseekerposts.index');

    Route::post('/helpseekerposts/{post}/update-status', [AdminController::class, 'updateStatus'])
    ->name('admin.helpseekerposts.update_status');





    // Helpseeker Post Reports
Route::get('/helpseeker-posts/report', [HelpseekerPostReportController::class, 'index'])
    ->name('helpseekerposts.report');

Route::get('/helpseeker-posts/report/{post}', [HelpseekerPostReportController::class, 'details'])
    ->name('helpseekerposts.report.details');

Route::get('/helpseeker-posts/report/{post}/print', [HelpseekerPostReportController::class, 'print'])
    ->name('helpseekerposts.report.print');


});

//     Route::post('/business/save-step', [GmeBusinessController::class, 'saveStep'])->name('business.save-step');
//     Route::get('/business/success', [GmeBusinessController::class, 'success'])->name('business.success');
// });












Route::middleware(['web', 'setLocale'])->group(function () {
    // Route::get('/', [GuestController::class, 'landingPage']);

    // Route::get('/gme-guest/business/register', [GuestController::class, 'showRegisterForm'])->name('gme.business.register.guest');
    // Route::post('/gme-guest/business/save-step', [GuestController::class, 'saveStep'])->name('gme.business.save-step.guest');
    // Route::get('/gme-guest/business/complete-submission', [GuestController::class, 'completeSubmission'])->name('gme.business.complete-submission');
    // Route::get('/gme-guest/business/success', [GuestController::class, 'formSuccess'])->name('gme.business.success.guest');
    // Route::get('/gme-guest-get-services/{categoryId}', [GuestController::class, 'getServices']);


    Route::get('/business/register/form', [GuestController::class, 'guestForm'])->name('guest.form');
    Route::post('/business/register/save-step', [GuestController::class, 'guestSaveStep'])->name('guest.save-step');
    Route::get('/gme-guest/business/success', [GuestController::class, 'formSuccess'])->name('guest.success');
    Route::get('/gme-guest-get-services/{categoryId}', [GuestController::class, 'getServices']);
    
    //Index
    // Route::get('/', [GuestController::class, 'guestIndex'])->name('guest.index');
    
    Route::get('/guest-gme-businesses', [GuestController::class, 'indexAjax'])->name('guest.gme-business.ajax');
        // get category ajax
    Route::get('/guest-get-category', [GuestController::class, 'getCategoryAjax'])->name('guest.get-category.ajax');
        //get Location Ajax
    Route::get('/guest-get-locations', [GuestController::class, 'getLocationAjax'])->name('guest.get-locations.ajax');

 

    //View GME Business Details
    Route::get('/guest-gme-business-form/{business}', [GuestController::class, 'show'])->name('guest.gme-business-form.show');
//    Route::get('/gme-business-form/{business}', [CustomerController::class, 'show'])->name('customer.gme-business-form.show');





    Route::get('admin/login', [AuthController::class, 'showLoginForm']);
    Route::post('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});

// Route for log
Route::get('/show-log', function () {
    $logPath = storage_path('logs/laravel.log');
    if (!file_exists($logPath)) {
        abort(404, 'Log file not found.');
    }
    return response()->file($logPath, [
        'Content-Type' => 'text/plain'
    ]);
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
    // Route::get('/business/success', [GmeRegController::class, 'success'])->name('gme.business.success');
    Route::get('/get-services/{category}', [GmeRegController::class, 'getServices'])->name('get.services');

});






// Route::post('/logout', [CustomerAuthController::class, 'logout'])->middleware('auth:customer');
Route::post('/forgot-password', [CustomerAuthController::class, 'forgotPassword']);
Route::post('/verify-otp', [CustomerAuthController::class, 'verifyOtp']);
Route::post('/reset-password', [CustomerAuthController::class, 'resetPassword']);





Route::middleware([
    'setLocale',
    CustomerAuth::class,
])->group(function () {

    //////// This is for Customer Own (OK)/////////////


        Route::get('/business/register', [GmeRegController::class, 'showRegisterForm'])->name('gme.business.register');
        Route::get('/gme-business-index', [CustomerController::class, 'gmeBusinessIndex'])->name('customer.gme-business-form.index');

        // API route (JSON ONLY)
        Route::get('/api/customer/gme-businesses', [CustomerController::class, 'indexAjax'])
            ->name('customer.gme-business.ajax');
        // get category ajax
        Route::get('/get-category', [CustomerController::class, 'getCategoryAjax'])->name('customer.get-category.ajax');
        //get Location Ajax
        Route::get('/get-locations', [CustomerController::class, 'getLocationAjax'])->name('customer.get-locations.ajax');



    ///////////////////////////////////////////////////


    Route::get('/customer/dashboard', [CustomerAuthController::class, 'customerDashboard'])->name('customer.dashboard');
    Route::get('/customer/logout', [CustomerAuthController::class, 'cusLogout'])->name('customer.logout');


    Route::get('/customer/profile', [CustomerController::class, 'customerProfile'])->name('customer.profile');
    Route::put('/customer/profile', [CustomerController::class, 'updateProfile'])->name('customer.profile.update');

    Route::get('/update-password', [CustomerController::class, 'updatePassword'])->name('customer.updatePassword');
    Route::post('/update-password', [CustomerController::class, 'storeUpdatePassword'])->name('customer.storeUpdatePassword');


    Route::get('/gme-business-form', [CustomerController::class, 'createGmeBusinessForm'])->name('customer.gme-business-form.create');

    Route::get('/gme-business-form/{business}', [CustomerController::class, 'show'])->name('customer.gme-business-form.show');


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



    // Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    // Route::resource('categories', CategoryController::class);
    // Route::resource('crises', CrisisController::class);
    // Route::resource('categories', CategoryController::class);

    // Route::resource('services', ServiceController::class);

    Route::resource('gme-business', FrontendGmeBusinessController::class);

    Route::resource('gme-business-admin', GmeBusinessAdminController::class);

    Route::group(['prefix' => 'user'], function () {

        // Route::resource('user', UserController::class);
        Route::get('/', [UserController::class, 'index'])->name('user.index');
        Route::get('/create', [UserController::class, 'create'])->name('user.create');
        Route::post('/store', [UserController::class, 'store'])->name('user.store');
        Route::get('/edit/{user}', [UserController::class, 'edit'])->name('user.edit');
        Route::post('/update/{user}', [UserController::class, 'update'])->name('user.update');
        Route::delete('/delete/{user}', [UserController::class, 'destroy'])->name('user.destroy');

        // Route::get('settings', [UserController::class, 'userSettings'])->name('users.settings');
        Route::post('store/settings', [UserController::class, 'updateUserSettings'])->name('user.store-settings');
        Route::get('profile/update', [UserController::class, 'userProfileUpdate'])->name('user.profileUpdate');
        Route::post('profile/update', [UserController::class, 'storeUserProfileUpdate'])->name('user.profileUpdate');

        Route::get('/change-password', [UserController::class, 'changePassword'])->name('user.changePassword');
        Route::post('/change-password', [UserController::class, 'storeChangePassword'])->name('user.changePassword');
        Route::get('/settings', [UserController::class, 'userSettings'])->name('user.settings');
    });




});