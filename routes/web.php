<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\RoomController;
use App\Http\Controllers\Admin\RoomTypeController;
use App\Http\Controllers\Admin\ReservationController;
use App\Http\Controllers\Admin\GuestController;
use App\Http\Controllers\Admin\HousekeepingController;
use App\Http\Controllers\Admin\MaintenanceController;
use App\Http\Controllers\Admin\FinancialController;
use App\Http\Controllers\Admin\GroupController;
use App\Http\Controllers\Admin\BlacklistController;
use App\Http\Controllers\Admin\ReportWebController;
use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\EmployeeWebController;
use App\Http\Controllers\Admin\HousekeepingTaskController;
use App\Http\Controllers\Admin\MaintenanceTicketController;
use App\Http\Controllers\Admin\GuestIncidentController;


// ========================
// Public / Landing
// ========================
Route::view('/', 'landing')->name('landing');


// ========================
// Admin Auth (guest only)
// ========================


Route::prefix('admin')->name('admin.')->middleware('guest')->group(function () {
    Route::get('login',    [AdminAuthController::class, 'showLoginForm'])->name('login');
    Route::post('login',   [AdminAuthController::class, 'login'])->name('login.post');

    Route::get('register', [AdminAuthController::class, 'showRegisterForm'])->name('register');
    Route::post('register',[AdminAuthController::class, 'register'])->name('register.post');
});

// aliases so auth middleware can redirect correctly
Route::get('/login', fn () => redirect()->route('admin.login'))->name('login');
Route::get('/register', fn () => redirect()->route('admin.register'))->name('register');

// logout (not behind guest)
Route::post('/admin/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');


// ========================
// Admin (protected)
// ========================
Route::prefix('admin')->name('admin.')->middleware('auth')->group(function () {

    // Dashboard
    
    Route::get('/',               [DashboardController::class, 'index'])->name('dashboard');
   

    // Rooms / Room Types
   
    Route::resource('rooms', RoomController::class)->names('rooms');

    Route::resource('room-types', RoomTypeController::class)->names('room-types');
    

    // Reservations / Guests
    Route::resource('reservations', ReservationController::class)->names('reservations');
    Route::get('guests',          [GuestController::class, 'index'])->name('guests.index');

    // Housekeeping / Maintenance
    
    
    // Housekeeping
    Route::resource('housekeeping', HousekeepingTaskController::class)
        ->names('housekeeping');
    Route::patch('housekeeping/{housekeeping}/complete', [HousekeepingTaskController::class,'complete'])
        ->name('housekeeping.complete');
    Route::patch('housekeeping/{housekeeping}/reopen', [HousekeepingTaskController::class,'reopen'])
        ->name('housekeeping.reopen');
    
    // Maintenance
    Route::resource('maintenance', MaintenanceTicketController::class)
        ->names('maintenance');
    Route::patch('maintenance/{maintenance}/close',  [MaintenanceTicketController::class,'close'])
        ->name('maintenance.close');
    Route::patch('maintenance/{maintenance}/reopen',[MaintenanceTicketController::class,'reopen'])
        ->name('maintenance.reopen');
    

    // Finance
    Route::get('finance',         [FinancialController::class, 'index'])->name('finance.index');

    // Groups / guests
    // routes/web.php (inside the auth-protected admin group)
   Route::post('guests/quick-store', [GuestController::class, 'quickStore'])
       ->name('guests.quick-store');

   Route::resource('guests',  GuestController::class)->names('guests');
   Route::resource('groups',  GroupController::class)->names('groups');
   /*
    Route::get('blacklist',              [BlacklistController::class,'index'])->name('blacklist.index');
    Route::get('blacklist/create',       [BlacklistController::class,'create'])->name('blacklist.create');
    Route::post('blacklist',             [BlacklistController::class,'store'])->name('blacklist.store');
    Route::get('blacklist/{guest}/history', [BlacklistController::class,'history'])->name('blacklist.history');
    Route::patch('blacklist/{guest}/remove', [BlacklistController::class,'remove'])->name('blacklist.remove');


Route::post('guests/{guest}/incidents', [GuestIncidentController::class, 'store'])->name('guests.incidents.store');

*/

    // Reports (web)
    Route::get('reports',                 [ReportWebController::class, 'index'])->name('reports.index');
    Route::get('reports/profit-loss',     [ReportWebController::class, 'profitLoss'])->name('reports.profit-loss');
    Route::get('reports/annual-ledger',   [ReportWebController::class, 'annualLedger'])->name('reports.annual-ledger');
    Route::get('reports/cashbox',         [ReportWebController::class, 'cashbox'])->name('reports.cashbox');
    //employees 

    Route::get('employees', [EmployeeWebController::class, 'index'])
    ->name('employees.index');

});



Route::get('reports/profit-loss',   [ReportWebController::class, 'profitLoss'])->name('admin.reports.profit_loss');
