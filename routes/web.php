<?php

use App\Http\Controllers\Payments\PesapalIpnController;
use App\Http\Controllers\Payments\PesapalPaymentController;
use App\Http\Controllers\Platform\Account\Auth\ConfirmPasswordController;
use App\Http\Controllers\Platform\Account\Auth\ForgotPasswordController;
use App\Http\Controllers\Platform\Account\Auth\LoginController;
use App\Http\Controllers\Platform\Account\Auth\RegisterController;
use App\Http\Controllers\Platform\Account\Auth\ResetPasswordController;
use App\Http\Controllers\Platform\Account\Auth\VerificationController;
use App\Http\Controllers\Platform\Account\Manage\ChangePasswordController;
use App\Http\Controllers\Platform\Account\Manage\ManageAccountController;
use App\Http\Controllers\Platform\Account\Manage\VerifyPhoneController;
use App\Http\Controllers\Platform\Adverts\CreateAdvertController;
use App\Http\Controllers\Platform\Adverts\GetAdvertsController;
use App\Http\Controllers\Platform\Adverts\SingleAdvertController;
use App\Http\Controllers\Platform\Billing\InvoicesController;
use App\Http\Controllers\Platform\Billing\SingleInvoiceController;
use App\Http\Controllers\Platform\User\UserActivityController;
use Illuminate\Support\Facades\Route;

// React app
// Route::view('app/{path?}', 'react.platform')->name('platform');

// Payments
Route::prefix('pesapal')
->name('pesapal.')
->group(function (){
    Route::get('pay/{invoice_number}', PesapalPaymentController::class)->name('payment');
    Route::get('received', [PesapalPaymentController::class, 'callback'])->name('received');
    Route::get('ipn', [PesapalIpnController::class, 'index'])->name('ipn');
});

Route::view('', 'web.home')->name('home');

// Admin
Route::prefix('admin')
->name('admin.')
->middleware('auth:staff')
->group(function(){
    require __DIR__.'/admin.php';
});

Route::get('auth/password/reset/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');

// Auth
Route::prefix('auth')
->name('platform.auth.')
->group(function(){
    Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('login', [LoginController::class, 'login']);

    Route::get('logout', [LoginController::class, 'logout'])->name('logout');

    Route::get('register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('register', [RegisterController::class, 'register']);

    Route::get('password/reset', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
    Route::post('password/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
    Route::post('password/reset', [ResetPasswordController::class, 'reset'])->name('password.update');

    Route::get('password/confirm', [ConfirmPasswordController::class], 'showConfirmForm')->name('password.confirm');
    Route::post('password/confirm', [ConfirmPasswordController::class], 'confirm');

    Route::get('email/verify', [VerificationController::class, 'show'])->name('verification.notice');
    Route::get('email/verify/{id}/{hash}', [VerificationController::class, 'verify'])->name('verification.verify');
    Route::post('email/resend', [VerificationController::class, 'resend'])->name('verification.resend');
});

// Web platfrom
Route::prefix('platform')
->name('platform.')
->middleware('auth:platform')
->group(function(){

    Route::get('', [UserActivityController::class, 'home'])->name('dashboard');

    // Adverts
    Route::prefix('ads')
    ->name('ads.')
    ->group(function(){

        // Create
        Route::get('create', CreateAdvertController::class)->name('create');
        Route::post('create', CreateAdvertController::class)->name('create');

        // Manage
        Route::get('all', GetAdvertsController::class)->name('all');

        Route::prefix('{advert_id}')
        ->group(function(){

            Route::get('', SingleAdvertController::class)->name('single');

            Route::get('edit', SingleAdvertController::class)->name('edit');
            Route::post('edit', [SingleAdvertController::class, 'edit'])->name('edit');

            Route::post('delete', [SingleAdvertController::class, 'delete'])->name('delete');

        });

    });

    // Invoices
    Route::prefix('invoices')
    ->name('invoices.')
    ->group(function(){

        Route::get('', InvoicesController::class)->name('all');
        Route::get('{invoice_number}', SingleInvoiceController::class)->name('single');
        Route::get('{invoice_number}/file', [SingleInvoiceController::class, 'asFile'])->name('as_file');
        Route::get('{invoice_number}/pay', [SingleInvoiceController::class, 'pay'])->name('pay');

    });

    // User Account
    Route::prefix('user')
    ->name('user.')
    ->group(function(){

        Route::get('account', ManageAccountController::class)->name('account');

        Route::post('verify/phone', [VerifyPhoneController::class, 'sendCode'])->name('verify_phone');
        Route::post('verify/phone/finish', [VerifyPhoneController::class, 'verifyCode'])->name('verify_phone.finish');

        Route::post('password', ChangePasswordController::class)->name('password');
    });

});

Route::view('terms', 'web.terms')->name('terms');
