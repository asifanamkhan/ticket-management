<?php

use App\Models\User;
use Illuminate\Http\Request;
use App\Repositories\Order\Order;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\CartController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\QrCodeController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\Admin\DayController;
use App\Http\Controllers\Admin\LogController;
use App\Http\Controllers\SocialiteController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Order\OrderController;
use App\Http\Controllers\Admin\PackageController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\VisitorController;
use App\Http\Controllers\Admin\ActivityController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\Auth\LoginController;
use App\Http\Controllers\Admin\BulkImportController;
use App\Http\Controllers\Admin\InternalUserController;
use App\Http\Controllers\Admin\Auth\RegisterController;
use App\Http\Controllers\Order\OrderActivityController;
use App\Http\Controllers\Admin\Order\OrderManageController;
use App\Http\Controllers\SpecialUser\SpecialUserController;
use App\Http\Controllers\Admin\Auth\ResetPasswordController;
use App\Http\Controllers\Admin\Auth\ForgotPasswordController;
use App\Http\Controllers\Admin\Auth\ConfirmPasswordController;
use App\Http\Controllers\Admin\SpecialUserController as AdminSpecialUserController;

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

Route::get('check/qty', function () {
    $activityQtys = DB::table('order_details')
    ->leftJoin('orders', 'orders.id', '=', 'order_details.order_id')
    ->leftJoin('order_activities', 'order_activities.order_detail_id', '=', 'order_details.id')
    ->where('orders.user_id', Auth::user()->id)
    ->where('order_details.type_id', 1)
    ->where('order_details.package_id', 9)
    ->where('order_details.day_name', 'Sunday')
    ->where('order_activities.activity_id', 3)
    ->select(DB::raw("sum(order_activities.qty) as total"))
    ->first();
    var_dump($activityQtys);
});

Route::get('/home', function () {
    return view('home');
})->middleware('auth');

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::post('/ajax/home', [CartController::class, 'ajaxIndex']);
// Visitor
Route::group(['middleware' => 'auth', 'as' => 'visitor.'], function(){
    Route::resource('profile', UserController::class);
    Route::resource('orders', OrderController::class);
    Route::get('qrcode/download', [QrCodeController::class, 'download'])->name('qrcode.download');
    Route::post('payment', [CheckoutController::class, 'checkout'])->name('checkout')->middleware('verified');

    Route::get('/order-payment/{order_id}', [OrderController::class, 'payment'])->name('order.payment');

    Route::post('add-order-addon', [OrderActivityController::class, 'addAddon'])->name('add.order.addon');
});

// Special User
Route::group(['prefix' => 'special-user','as' => 'special-user.'], function() {
    
    // Login
    Route::get('/register', [\App\Http\Controllers\SpecialUser\Auth\RegisterController::class, 'showRegisterForm'])->name('register.form');
    Route::post('/register', [\App\Http\Controllers\SpecialUser\Auth\RegisterController::class, 'register'])->name('register');

    // Login
    Route::get('/login', [\App\Http\Controllers\SpecialUser\Auth\LoginController::class, 'showLoginForm'])->name('login.form');
    Route::post('/login', [\App\Http\Controllers\SpecialUser\Auth\LoginController::class, 'login'])->name('login');


    Route::resource('/user', SpecialUserController::class);
    


});

Route::group(['middleware' => ['auth:specialUser'], 'prefix' => 'special-user','as' => 'special-user.'], function() {
    Route::get('/', [SpecialUserController::class, 'index'])->name('home');
    Route::get('/profile/{id}', [SpecialUserController::class, 'profile'])->name('profile');
    Route::put('/profile/{id}', [SpecialUserController::class, 'updateProfile'])->name('profile.update');
    Route::get('/password-change/{id}', [SpecialUserController::class, 'passwordChange'])->name('password.change');
    Route::put('/password-update/{id}', [SpecialUserController::class, 'passwordUpdate'])->name('password.update');
});

Route::get('/scan/packages/{id}', function(){
    return 'Packages';
})->name('scan.packages');

Route::group(['prefix' => 'dashboard', 'as' => 'admin.'], function(){
    // Admin registration
    Route::get('/register', [RegisterController::class, 'showRegisterForm'])->name('register.form');
    Route::post('/register', [RegisterController::class, 'register'])->name('register');
    // Admin Login
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login.form');
    Route::post('/login', [LoginController::class, 'login'])->name('login');
    // Admin Logout
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
    // Confirm Admin Passowrd
    Route::get('/password/confirm', [ConfirmPasswordController::class, 'showConfirmForm'])->name('password.confirm');
    Route::post('/password/confirm', [ConfirmPasswordController::class, 'showConfirmForm']);
    // Forgot Admin Password
    Route::get('/password/reset', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
    Route::post('/password/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
    // Reset Admin Password
    Route::get('/password/reset/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
    Route::post('/password/reset', [ResetPasswordController::class, 'reset'])->name('password.update');


});

Route::group(['middleware' => 'auth:admin', 'prefix' => 'dashboard', 'as' => 'admin.'], function(){
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    // Visitors Dashboard
    Route::resource('visitors',  VisitorController::class);
    // Activities or Add ons Dashboard
    Route::resource('activities', ActivityController::class);
    // Days Dashboard
    Route::resource('days',  DayController::class);
    // Packages Dashboard
    Route::resource('packages', PackageController::class);
    // Orders Dashboard
    Route::resource('orders', OrderManageController::class);
    // Roles Dashboard
    Route::resource('roles', RoleController::class);
    // Special Users Dashboard
    Route::resource('specials', AdminSpecialUserController::class);
    // Internal Users Dashboard
    Route::resource('internals', InternalUserController::class);
    // Internal Users Dashboard
    Route::resource('bulk-imports', BulkImportController::class);


    //Visitor password change
    Route::get('/visitor/password-change/{id}', [VisitorController::class, 'passwordChange'])->name('visitors.password.change');
    Route::put('/visitor/password-update/{id}', [VisitorController::class, 'passwordUpdate'])->name('visitors.password.update');
    Route::get('/visitor/email-ticket/{id}', [VisitorController::class, 'emailTicket'])->name('visitors.emailTicket');

    //Special user password change
    Route::get('/special/password-change/{id}', [AdminSpecialUserController::class, 'passwordChange'])->name('special.password.change');
    Route::put('/special/password-update/{id}', [AdminSpecialUserController::class, 'passwordUpdate'])->name('special.password.update');

    Route::get('bulk-imports-file-upload', [BulkImportController::class, 'fileUpload'])->name('bulk.file.upload');
    Route::post('bulk-imports-mapping', [BulkImportController::class, 'mapping'])->name('bulk.mapping');
    Route::post('bulk-imports-save', [BulkImportController::class, 'save'])->name('bulk.save');

    Route::post('order-status/filter', [OrderManageController::class, 'statusFilter'])->name('order.status.filter');


    // Profile
    Route::get('/profile/{id}', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile/{id}', [ProfileController::class, 'update'])->name('profile.update');

    Route::delete('/image-delete/{id}/{image}', [ActivityController::class, 'imageDelete'])->name('activities.image.delete');

    //log Add on
    Route::get('/log/add-on', [LogController::class, 'addOnIndex'])->name('log.add-on.index');
    Route::get('/activity-log/add-on/show/{id}', [LogController::class, 'addOnShow'])->name('log.add-on.show');
    //log Packages
    Route::get('/log/package', [LogController::class, 'packageIndex'])->name('log.package.index');
    Route::get('/log/add-on/package/{id}', [LogController::class, 'packageShow'])->name('log.package.show');
    //log Visiotor
    Route::get('/log/visitor', [LogController::class, 'visitorIndex'])->name('log.visitor.index');
    Route::get('/log/visitor/{id}', [LogController::class, 'visitorShow'])->name('log.visitor.show');

    // Ajax
    Route::get('/ajax/days/{type_id}', [OrderManageController::class, 'getDays']);
    Route::get('/ajax/packages/{day_id}', [OrderManageController::class, 'getPackages']);
    Route::get('/ajax/activities/{package_id}', [OrderManageController::class, 'getActivities']);
});

Auth::routes(['verify' => true]);
Route::get('/auth/{provider}', [SocialiteController::class, 'redirectToProvider'])->name('socialite.auth.provider');
Route::get('/auth/{provider}/callback', [SocialiteController::class, 'handleProviderCallback'])->name('socialite.auth.callback');

// Cart
Route::get('/package/{package_id}/quantity', [CartController::class, 'getPackageQuantity']);
Route::resource('/cart', CartController::class);

Route::post('/cart/remove/addon', [CartController::class, 'removeAddon']);
Route::post('/cart/remove/concert', [CartController::class, 'removeConcert']);
Route::post('/cart/check-activity', [CartController::class, 'checkActivity']);

Route::get('/clear/cart', [CartController::class, 'clear']);
Route::get('/cart-amount', [CartController::class, 'cartTotal']);
Route::resource('/checkout', CheckoutController::class);



Route::get('/theme-mode-switcher', function() {
    $mode = 'dark';
    if ( Session::get('theme_mode') === 'dark') {
        $mode = 'light';
    } else if (Session::get('theme_mode') === 'light') {
        $mode = 'dark';
    }

    Session::put('theme_mode', $mode);

    return back();

})->name('theme-mode-switcher');

Route::get('thankyou', function(){
    return 'Thanks for the purchase. Enjoy the event.';
})->name('thankyou');

Route::get('cancel', function(){
    return 'You cancel the payment.';
})->name('cancel');

Route::get('error', function(){
    return 'Something went wrong. Please contact support.';
})->name('error');


Route::post('paytabs/completed', [PaymentController::class, 'completed'])->name('paytabs.return');

Route::any('paytabs/callback', [PaymentController::class, 'paytabsCallback'])->name('paytabs.callback');

Route::post('paytabs/addon/completed', [PaymentController::class, 'addon'])->name('paytabs.addon.return');

Route::any('paytabs/addon/callback', [PaymentController::class, 'paytabsAdonCallback'])->name('paytabs.addon.callback');


