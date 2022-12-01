<?php

use App\Http\Controllers\AllowableAreaController;
use App\Http\Controllers\AttendanceRecordController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\KaryawanHomeController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return redirect(route("login"));
});

Auth::routes();

Route::group([
    "middleware" => "auth",
    "as" => "admin.",
    "prefix" => "admin"
], function () {
    Route::group([
        "as" => "users.",
        "prefix" => "users",
    ], function () {
        Route::get("/", [UserController::class, 'index'])->name("index");
        Route::get("/create", [UserController::class, 'create'])->name("create");
        Route::post("/", [UserController::class, 'store'])->name("store");
        Route::get("/{user}/edit", [UserController::class, 'edit'])->name("edit");
        Route::post("/{user}/update", [UserController::class, 'update'])->name("update");
        Route::post("/{user}/delete", [UserController::class, 'delete'])->name("delete");
        Route::post("/{user}/approve-device", [UserController::class, 'approveDevice'])->name("approve-device");
    });

    Route::group([
        "as" => "areas.",
        "prefix" => "areas",
    ], function () {
        Route::get("/", [AllowableAreaController::class, 'index'])->name("index");
        Route::get("/create", [AllowableAreaController::class, 'create'])->name("create");
        Route::post("/", [AllowableAreaController::class, 'store'])->name("store");
        Route::post("/{allowable_area}/update", [AllowableAreaController::class, 'update'])->name("update");
        Route::post("/{allowable_area}/delete", [AllowableAreaController::class, 'delete'])->name("delete");
    });

    Route::group([
        "as" => "attendance-records.",
        "prefix" => "attendance-records",
    ], function () {
        Route::get("/", [AttendanceRecordController::class, 'index'])->name("index");
        Route::get("/data", [AttendanceRecordController::class, 'data'])->name("data");
        // Route::post("/{attendance_record}/delete", [AttendanceRecordController::class, 'delete'])->name("delete");
    });

    Route::get("/home", [HomeController::class, 'index'])->name("dashboard");
});

Route::group([
    "middleware" => "auth",
    "as" => "karyawan.",
    "prefix" => "karyawan",
],
function () {
    Route::get("/home", [KaryawanHomeController::class, 'index'])->name("dashboard");
    Route::post("/absen", [KaryawanHomeController::class, 'absen'])->name("absen");
    Route::post("/register-device", [KaryawanHomeController::class, 'registerDevice'])->name("register-device");
}); 