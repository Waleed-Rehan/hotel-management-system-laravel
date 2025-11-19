<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\RoomTypeController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\GuestController;
use App\Http\Controllers\HousekeepingController;
use App\Http\Controllers\MaintenanceController;
use App\Http\Controllers\FinancialController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\BlacklistController;
use App\Http\Controllers\ReportController;

Route::post('/auth/login', [AuthController::class, 'login']);
Route::post('/auth/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');

Route::middleware(['auth:sanctum'])->group(function () {
    Route::apiResource('rooms', RoomController::class);
    Route::apiResource('room-types', RoomTypeController::class);
    Route::apiResource('guests', GuestController::class);
    Route::apiResource('reservations', ReservationController::class);
    Route::post('reservations/{reservation}/extend', [ReservationController::class, 'extend']);
    Route::post('reservations/{reservation}/checkin', [ReservationController::class, 'checkin']);
    Route::post('reservations/{reservation}/checkout', [ReservationController::class, 'checkout']);
    Route::get('calendar/daily', [ReservationController::class, 'calendarDaily']);
    Route::get('calendar/range', [ReservationController::class, 'calendarRange']);

    Route::get('cashbox/summary', [FinancialController::class, 'cashboxSummary']);
    Route::get('reports/pl', [ReportController::class, 'profitLoss']);
    Route::get('reports/annual-ledger', [ReportController::class, 'annualLedger']);
    Route::post('financial/transactions', [FinancialController::class, 'store']);
    Route::put('financial/transactions/{txn}', [FinancialController::class, 'update']);

    Route::apiResource('housekeeping', HousekeepingController::class)->only(['index','store','update']);
    Route::post('housekeeping/{task}/complete', [HousekeepingController::class, 'complete']);

    Route::apiResource('maintenance', MaintenanceController::class)->only(['index','store','update']);
    Route::post('maintenance/{ticket}/request-tools', [MaintenanceController::class, 'requestTools']);
    Route::post('maintenance/{ticket}/complete', [MaintenanceController::class, 'complete']);

    Route::apiResource('groups', GroupController::class)->only(['index','store','show']);
    Route::get('groups/{group}/rooms-count', [GroupController::class, 'roomsCount']);

    Route::apiResource('blacklist', BlacklistController::class)->only(['index','store','destroy']);
});
