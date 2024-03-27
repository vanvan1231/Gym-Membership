<?php

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ReportController;

// --------------------------
// Custom Backpack Routes
// --------------------------
// This route file is loaded automatically by Backpack\Base.
// Routes you generate using Backpack\Generators will be placed here.

Route::group([
    'prefix' => config('backpack.base.route_prefix', 'admin'),
    'middleware' => array_merge(
        (array) config('backpack.base.web_middleware', 'web'),
        (array) config('backpack.base.middleware_key', 'admin'),
        ['capabilities']
    ),
    'namespace' => 'App\Http\Controllers\Admin',
], function () { // custom admin routes
    Route::crud('user', 'UserCrudController');
    // Route::crud('membership', 'MembershipCrudController');
    Route::crud('payment', 'PaymentCrudController');
    Route::crud('member', 'MemberCrudController');
    Route::crud('checkin', 'CheckinCrudController');
    Route::get('dashboard', [Controller::class, 'dashboard'])->name('dashboard');
    Route::get('show-checkins', [ReportController::class, 'showCheckin'])->name('show-checkins');
    Route::get('show-member', [ReportController::class, 'showMember'])->name('show-member');
    Route::get('show-payments', [ReportController::class, 'showPayments'])->name('show-payments');
    Route::get('cashflow', [ReportController::class, 'cashflow'])->name('cashflow');
}); // this should be the absolute last line of this file
