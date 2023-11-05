<?php

use App\Http\Controllers\Api\AdminController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\BridePackageController;
use App\Http\Controllers\Api\EventController;
use App\Http\Controllers\Api\PostController;
use App\Http\Controllers\Api\ReceiptionController;
use App\Http\Controllers\Api\ServiceController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout']);
Route::get('/notifications', [AdminController::class, 'get_all_notifications']);



Route::middleware(['CheckSuperAdmin', 'auth:sanctum'])->group(function () {
    Route::post('create_admin', [AdminController::class, 'create_admin']);
    Route::post('create_receiption', [AdminController::class, 'create_receiption']);
    Route::delete('/delete-expert/{expert}', [AdminController::class, 'delete_expert']);
    Route::delete('/delete-reservation/{reservation}', [AdminController::class, 'delete_reservation']);
    Route::delete('/delete-client/{client}', [AdminController::class, 'delete_client']);
    Route::delete('/delete-notification/{notification}', [AdminController::class, 'delete_notification']);
    Route::patch('update_client', [ReceiptionController::class, 'update_client']);
    Route::post('update_expert', [AdminController::class, 'update_expert']);
});



Route::middleware(['CheckReseiption', 'auth:sanctum'])->group(function () {
    Route::post('create_client', [ReceiptionController::class, 'create_client']);

    Route::post('create_reservation', [ReceiptionController::class, 'create_reservation']);
    Route::post('complete_reservation', [ReceiptionController::class, 'complete_reservation']);
    Route::post('cancle_reservation', [ReceiptionController::class, 'cancle_reservation'])->middleware('HavePermisstionCancle');
    Route::post('delay_reservation', [ReceiptionController::class, 'delay_reservation'])->middleware('RecieptionCanDelay');
    Route::get('get_reservation/{id}', [ReceiptionController::class, 'get_reservation']);
});

Route::middleware(['CheckAdmin', 'auth:sanctum'])->group(function () {
    Route::post('create_transfer', [AdminController::class, 'create_transfer']);
    Route::post('update_transfer', [AdminController::class, 'update_transfer']);
    Route::delete('transfer/{id}', [AdminController::class, 'delete_transfer']);
    Route::patch('update_receiption', [AdminController::class, 'update_receiption']);
    Route::get('transfer/{id}', [AdminController::class, 'delete_transfer']);
    Route::get('list_of_transfers', [AdminController::class, 'list_of_transfers']);
    Route::get('export', [AdminController::class, 'export']);
    Route::post('create_expert', [AdminController::class, 'create_expert']);
    Route::get('list_of_receiptions', [AdminController::class, 'list_of_receiptions']);
    Route::post('create_holiday', [AdminController::class, 'create_holiday']);
    Route::post('chang_permission', [AdminController::class, 'chang_permission']);
    Route::delete('/delete-expert/{expert}', [AdminController::class, 'delete_expert']);
    Route::delete('delete_receiption/{id}', [AdminController::class, 'delete_receiption']);
    Route::delete('/delete-reservation/{reservation}', [AdminController::class, 'delete_reservation']);
    Route::delete('/delete-client/{client}', [AdminController::class, 'delete_client']);
    Route::delete('/delete-notification/{notification}', [AdminController::class, 'delete_notification']);
    Route::post('create_receiption', [AdminController::class, 'create_receiption']);
    Route::get('most_active_client', [AdminController::class, 'most_active_client']);
    Route::get('number_daily_clients', [AdminController::class, 'number_daily_clients']);
    Route::get('export_pdf', [AdminController::class, 'export_pdf']);
    Route::post('update_expert', [AdminController::class, 'update_expert']);
    Route::post('create_event', [EventController::class, 'create_event']);
    Route::patch('update_event', [EventController::class, 'update_event']);
    Route::delete('event/{id}', [EventController::class, 'delete_event']);
    Route::get('get_events_list', [EventController::class, 'get_events_list']);
    Route::post('create_bride_package', [BridePackageController::class, 'create_bride_package']);
    Route::patch('update_bride_package', [BridePackageController::class, 'update_bride_package']);
    Route::delete('bride_package/{id}', [BridePackageController::class, 'delete_bride_package']);
    Route::get('get_bride_packages_list', [BridePackageController::class, 'get_bride_packages_list']);
    Route::get('reservations_history', [AdminController::class, 'reservations_history']);
    Route::post('create_service', [ServiceController::class, 'create_service']);
    Route::patch('update_service', [ServiceController::class, 'update_service']);
    Route::delete('service/{id}', [ServiceController::class, 'delete_service']);
});

Route::middleware(['CheckAdminReceiption', 'auth:sanctum'])->group(function () {
    Route::get('list_of_experts', [AdminController::class, 'list_of_experts']);
    Route::get('list_of_services', [AdminController::class, 'list_of_services']);
    Route::get('list_of_client', [ReceiptionController::class, 'list_of_client']);
    Route::patch('update_client', [ReceiptionController::class, 'update_client']);
    Route::put('confirm_reservation/{id}', [AdminController::class, 'confirm_reservation']);
    Route::get('get_events_list', [EventController::class, 'get_events_list']);
    Route::get('get_bride_packages_list', [BridePackageController::class, 'get_bride_packages_list']);
    Route::get('event/{id}', [EventController::class, 'show']);
    Route::get('bride_package/{id}', [BridePackageController::class, 'show']);
    Route::get('service/{id}', [ServiceController::class, 'show']);
    Route::get('get_services_list', [ServiceController::class, 'get_services_list']);
    Route::get('client_reservations', [ReceiptionController::class, 'client_reservations']);
});
