<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Setupcontroller;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/timetable',[AuthController::class,'index']);
Route::get('/register',[AuthController::class,'Register']);
Route::post('/register',[AuthController::class,'storeRegister']);
Route::get('/login',[AuthController::class,'login']);
Route::post('/login',[AuthController::class,'storeLogin']);
Route::get('/email/token/{token}',[AuthController::class,'verify']);
Route::get('test', function () {
    return view('Content.TimetableIndex');
});
Route::middleware('userauth')->group(function(){
    Route::get('/dashboard',[AuthController::class,'dashboard']);
    Route::get('/logout',[AuthController::class,'logout'])->name('logout');
    Route::prefix('setup')->group(function(){
        // Grade Route Start
        Route::get('/grade',[Setupcontroller::class,'grade'])->name('grade');
        Route::post('/grade',[Setupcontroller::class,'storegrade'])->name('storegrade');
        Route::get('/grade/edit/{id}',[Setupcontroller::class,'editGrade'])->name('editGrade');
        Route::post('/grade/edit/',[Setupcontroller::class,'updateGrade'])->name('updateGrade');
        Route::get('/grade/delete/{id}',[Setupcontroller::class,'deleteGrade'])->name('deleteGrade');
        // Grade Route Start

        // Subject Route Start
        Route::get('/subject',[Setupcontroller::class,'subject'])->name('subject');
        Route::post('/subject',[Setupcontroller::class,'storeSubject']);
        Route::get('/subject/edit/{id}',[Setupcontroller::class,'editSubject']);
        Route::post('/subject/edit/',[Setupcontroller::class,'updateSubject']);
        Route::get('/subject/delete/{id}',[Setupcontroller::class,'deleteSubject']);

        // Subject Route End


        Route::get('/teacher',[Setupcontroller::class,'teacher'])->name('teacher');
        Route::post('/teacher',[Setupcontroller::class,'storeTeacher']);
        Route::get('/teacher/edit/{id}',[Setupcontroller::class,'editTeacher']);
        Route::post('/teacher/edit',[Setupcontroller::class,'updateTeacher']);
        Route::get('/teacher/delete/{id}',[Setupcontroller::class,'deleteTeacher']);


        // Grade Detail View Start
        Route::get('/grade/view/{id}',[Setupcontroller::class,'viewDetail']);
        // Grade Detail View End

        // Time table generating table start
        Route::get('/timetable/generate',[Setupcontroller::class,'generateTimetable'])->name('timetable');
        Route::post('/timetable/create',[Setupcontroller::class,'createTimetable']);
        // Time table generating table End
    });
});
