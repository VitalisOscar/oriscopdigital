<?php

use App\Http\Controllers\Admin\Adverts\AdvertsController;
use App\Http\Controllers\Admin\Adverts\SingleAdvertController;
use App\Http\Controllers\Admin\Auth\LoginController;
use App\Http\Controllers\Admin\Auth\PasswordController;
use App\Http\Controllers\Admin\Billing\InvoicesController;
use App\Http\Controllers\Admin\Billing\BillingController;
use App\Http\Controllers\Admin\Categories\CategoriesController;
use App\Http\Controllers\Admin\Clients\ClientsController;
use App\Http\Controllers\Admin\Clients\SingleClientController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\Packages\PackagesController;
use App\Http\Controllers\Admin\Packages\SinglePackageController;
use App\Http\Controllers\Admin\Schedule\ScheduleController;
use App\Http\Controllers\Admin\Schedule\DownloadScheduleController;
use App\Http\Controllers\Admin\Schedule\PlaybackCommentsController;
use App\Http\Controllers\Admin\Screens\ScreensController;
use App\Http\Controllers\Admin\Screens\SingleScreenController;
use App\Http\Controllers\Admin\Staff\SingleStaffController;
use App\Http\Controllers\Admin\Staff\StaffActivityController;
use App\Http\Controllers\Admin\Staff\StaffController;
use Illuminate\Support\Facades\Route;

Route::view('login', 'admin.auth.login')
    ->withoutMiddleware('auth:staff')->name('auth.login');
Route::post('login', LoginController::class)
    ->withoutMiddleware('auth:staff')->name('auth.login');
Route::get('logout', function(){
    auth('staff')->logout();
    return redirect(route('admin.auth.login'));
})->name('logout');


Route::get('dashboard', DashboardController::class)->name('dashboard');
Route::get('', function(){
    return redirect(route('admin.dashboard'));
});

Route::prefix('ads')
->name('ads.')
->group(function(){

    Route::get('', [AdvertsController::class, 'getAll'])->name('all');

    Route::get('export', [AdvertsController::class, 'export'])->name('export');

    Route::get('{id}', [AdvertsController::class, 'getSingle'])->name('single');

    Route::post('{id}/approve', [SingleAdvertController::class, 'approve'])->name('approve');
    Route::post('{id}/reject', [SingleAdvertController::class, 'reject'])->name('reject');

});


// Schdule
Route::prefix('schedule')
->name('schedule.')
->group(function(){
    Route::get('', ScheduleController::class)->name('view');
    Route::get('download', DownloadScheduleController::class)->name('download');
    // Route::get('download/single', [DownloadScheduleController::class, 'single'])->name('download.single');
    // Route::post('comments/add', [PlaybackCommentsController::class, 'save'])->name('comments.add');
});


Route::prefix('data')
->group(function(){

    Route::get('categories', [])->name('categories');
    Route::post('categories/add', [])->name('categories');


    // Categories
    Route::prefix('categories')
    ->name('categories.')
    ->group(function(){
        // All
        Route::get('', [CategoriesController::class, 'getAll'])->name('all');

        Route::middleware(['admin'])->group(function(){
            // New
            Route::post('add', [CategoriesController::class, 'add'])->name('add');

            // Delete
            Route::post('{slug}/delete', [CategoriesController::class, 'delete'])->name('delete');
        });

        Route::get('export', [CategoriesController::class, 'export'])->name('export');

        // Ads in category
        // Route::get('{slug}/ads', [])->name('ads');
    });

    // Screens
    Route::prefix('screens')
    ->name('screens.')
    ->group(function(){
        // All
        Route::get('', [ScreensController::class, 'getAll'])->name('all');

        // New
        Route::post('add', [ScreensController::class, 'add'])->middleware(['admin'])->name('add');

        // Single screen
        Route::get('{screen_id}', [SingleScreenController::class, 'getScreen'])->name('single');
        Route::middleware(['admin'])->group(function(){
            Route::post('{screen_id}/delete', [SingleScreenController::class, 'delete'])->name('delete');
            Route::post('{screen_id}/edit', [SingleScreenController::class, 'edit'])->name('edit');
            Route::post('{screen_id}/pricing', [SingleScreenController::class, 'pricing'])->name('pricing');
        });
    });

    // Packages
    Route::prefix('packages')
    ->name('packages.')
    ->group(function(){
        // All
        Route::get('', [PackagesController::class, 'getAll'])->name('all');

        // Single
        Route::get('{id}/manage', SinglePackageController::class)->name('manage');

        Route::middleware(['admin'])->group(function(){
            // New
            Route::post('add', [PackagesController::class, 'add'])->name('add');
            Route::post('{id}/edit', [SinglePackageController::class, 'edit'])->name('edit');
            Route::post('{id}/pricing', [SinglePackageController::class, 'pricing'])->name('pricing');
        });
    });

});


Route::prefix('clients')
->name('clients.')
->group(function(){

    // View
    Route::get('', [ClientsController::class, 'getAll'])->name('all');
    Route::get('{email}', [SingleClientController::class, 'get'])->name('single');
    Route::get('{email}/certificate', [SingleClientController::class, 'viewCertificate'])->name('single.certificate');
    Route::get('{email}/kra_pin', [SingleClientController::class, 'viewKraPin'])->name('single.kra_pin');

    // Approve or reject
    Route::middleware(['admin'])->group(function(){
        Route::post('{email}/approve', [SingleClientController::class, 'verify'])->name('approve');
        Route::post('{email}/reject', [SingleClientController::class, 'reject'])->name('reject');
        Route::post('{email}/add-post-pay', [SingleClientController::class, 'addPostPay'])->name('add_post_pay');
        Route::post('{email}/remove-post-pay', [SingleClientController::class, 'removePostPay'])->name('remove_post_pay');
    });

});


Route::prefix('billing')
->name('billing.')
->group(function(){

    // Stats
    Route::get('stats', [BillingController::class, 'stats'])->name('stats');

    // Invoicing
    Route::get('invoices/all', [InvoicesController::class, 'getAll'])->name('invoices');
    Route::get('invoices/export', [InvoicesController::class, 'export'])->name('invoices.export');
    Route::get('invoices/{number}', [InvoicesController::class, 'getSingle'])->name('invoices.single');
    Route::get('invoices/{number}/file', [InvoicesController::class, 'asFile'])->name('invoices.single.as_file');
    Route::post('invoices/{number}/confirm-payment', [InvoicesController::class, 'confirmPayment'])->name('invoices.confirm_payment');

});

// Staff
Route::prefix('staff')
->name('staff.')
->middleware(['admin'])->group(function(){
    Route::get('', [StaffController::class, 'getAll'])->name('all');

    Route::get('add', [StaffController::class, 'add'])->name('add');
    Route::post('add', [StaffController::class, 'add'])->name('add');

    // Activity
    Route::get('logs', StaffActivityController::class)->name('activity');
    Route::get('logs/redirect/{item}/{id}', [StaffActivityController::class, 'redirect'])->name('activity.redirect');

    // Self
    Route::get('change-password', [PasswordController::class, 'change'])->name('password');
    Route::post('change-password', [PasswordController::class, 'change'])->name('password');

    Route::get('{username}', [SingleStaffController::class, 'get'])->name('single');
    // Route::middleware('password.confirm')->group(function(){
        Route::post('{username}/edit', [SingleStaffController::class, 'edit'])->name('edit');
        Route::post('{username}/delete', [SingleStaffController::class, 'delete'])->name('delete');
        Route::post('{username}/password', [SingleStaffController::class, 'resetPassword'])->name('password.reset');
    // });
});





// // Agents
// Route::prefix('agents')->group(function(){
//     // View
//     Route::get('', [AgentsController::class, 'getAll'])->name('admin.agents');
//     Route::view('add', 'admin.agents.add')->name('admin.agents.add');
//     Route::post('add', [AgentsController::class, 'add'])->name('admin.agents.add');
//     Route::get('{agent_id}', [SingleAgentController::class, 'get'])->name('admin.agents.single');
//     Route::post('{agent_id}/approve', [SingleAgentController::class, 'approve'])->name('admin.agents.single.approve');
//     Route::post('{agent_id}/deactivate', [SingleAgentController::class, 'reject'])->name('admin.agents.single.deactivate');
// });

