<?php

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/invitations/send', [App\Http\Controllers\InvitationController::class,'send']);
Route::post('/invitations/:id/cancel', [App\Http\Controllers\InvitationController::class,'cancel']);
Route::post('/invitations/:id/accept', [App\Http\Controllers\InvitationController::class,'accept']);
Route::post('/invitations/:id/decline', [App\Http\Controllers\InvitationController::class,'decline']);
