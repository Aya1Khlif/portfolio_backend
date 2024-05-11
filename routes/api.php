<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\MessageController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::group(['middleware' => 'jwt.auth'], function () {
    // عرض جميع المشاريع
    Route::get('projects', [ProjectController::class, 'index']);

    // إضافة مشروع جديد
    Route::post('projects', [ProjectController::class, 'store']);

    // عرض مشروع محدد
    Route::get('projects/{id}', [ProjectController::class, 'show']);

    // تحديث مشروع محدد
    Route::put('projects/{id}', [ProjectController::class, 'update']);

    // حذف مشروع محدد
    Route::delete('projects/{id}', [ProjectController::class, 'destroy']);

    // عرض جميع الرسائل
    Route::get('messages', [MessageController::class, 'index']);
    
    // عرض رسالة محددة
    Route::get('messages/{id}', [MessageController::class, 'show']);

    // حذف رسالة محددة
    Route::delete('messages/{id}', [MessageController::class, 'destroy']);
});
