<?php

use App\Http\Controllers\IndexController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\AdminController;

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

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/' , [IndexController::class,'index'])->name('index');
Route::get('/logout' , [AuthController::class,'logout'])->name('logout');

Route::get('/signin' , [AuthController::class,'show_signin'])->name('show_signin');
Route::post('/signin' , [AuthController::class,'signin'])->name('signin');

Route::get('/signup' , [AuthController::class,'show_signup'])->name('show_signup');
Route::post('/signup' , [AuthController::class,'signup'])->name('signup');
Route::get('/direction' , [IndexController::class,'direction'])->name('direction');

Route::get('/balet' , [IndexController::class,'balet'])->name('balet');
Route::get('/modern' , [IndexController::class,'modern'])->name('modern');
Route::get('/poleDanse' , [IndexController::class,'poleDanse'])->name('poleDanse');
Route::get('/childDanse' , [IndexController::class,'childDanse'])->name('childDanse');

Route::get('/search', [IndexController::class, 'index'])->name('search');

Route::get('/contact' , [IndexController::class,'contact'])->name('contact');
Route::get('/personal' , [IndexController::class,'user'])->name('user');
Route::get('/teacher' , [TeacherController::class,'teacher'])->name('teacher');
Route::post('/add-photo', [TeacherController::class, 'addPhoto'])->name('add.photo');
Route::delete('/delete-photo', [TeacherController::class, 'deletePhoto'])->name('delete.photo');

Route::post('/update_user_data' , [IndexController::class,'update_user_data'])->name('update_user_data');
Route::post('/update_teacher_data' , [IndexController::class,'update_teacher_data'])->name('update_teacher_data');


Route::post('/update-status', [TeacherController::class, 'updateStatus'])->name('updateStatusRecord');
Route::post('/record', [IndexController::class, 'store'])->name('store');
Route::post('/send-email', [IndexController::class, 'send'])->name('contact.send');

// панель администратора
Route::get('/admin/adminIndex' , [AdminController::class,'adminIndex'])->name('adminIndex');

Route::get('/admin/adminContant' , [AdminController::class,'adminContant'])->name('adminContant');

Route::get('/admin/comment' , [AdminController::class,'comment'])->name('comment');
Route::get('/admin/adminTiming' , [AdminController::class,'adminTiming'])->name('adminTiming');

Route::post('/timings/store', [AdminController::class, 'addTiming'])->name('addTiming');
Route::delete('/admin/timing/{id}', [AdminController::class, 'deleteTiming'])->name('deleteTiming');
Route::post('/admin/Addcomment' , [AdminController::class,'addComment'])->name('addComment');



Route::get('/admin/adminPerson' , [AdminController::class,'adminPerson'])->name('adminPerson');
Route::post('/signupTeacher' , [AuthController::class,'signupTeacher'])->name('signupTeacher');
Route::get('/admin/adminDirection' , [AdminController::class,'adminDirection'])->name('adminDirection');
Route::post('/addDirection' , [AdminController::class,'addDirection'])->name('addDirection');
Route::delete('/delete_direction/{id}' , [AdminController::class,'delete_direction'])->name('delete_direction');
Route::delete('/delete_teacher/{id}' , [AdminController::class,'delete_teacher'])->name('delete_teacher');
Route::put('/admin/comments/update/{id}', [AdminController::class, 'CommentUpdate'])->name('commentUpdate');
Route::post('/admin/updateDirection/', [AdminController::class, 'updateDirection'])->name('updateDirection');
Route::post('/admin/addDirectionTeacher/', [AdminController::class, 'addDirectionTeacher'])->name('addDirectionTeacher');
Route::delete('/deleteTiming/{id}' , [AdminController::class,'deleteTiming'])->name('deleteTiming');












