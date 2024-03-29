<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\FeedsController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\UploadController;


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

// use App\Http\Controllers\TodoController;

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::resource('/todo', 'App\Http\Controllers\TodoController');
Route::get('/get-fetch-tutor', [HomeController::class,'getFetchTeacher']);//'App\Http\Controllers\HomeController\getFetchTeacher');
Route::get('/get-teacher-information/{any}', [HomeController::class,'getTeacherInformation']);//'App\Http\Controllers\HomeController\getFetchTeacher');
Route::get('/get-student-information/{any}', [HomeController::class,'getStudentsInformation']);//'App\Http\Controllers\HomeController\getFetchTeacher');
Route::post('/register/teachers', [RegisterController::class,'createTeachers']);
Route::post('/register/students', [RegisterController::class,'createStudents']);

Route::post('/login/teachers', [LoginController::class,'teachersLogin'])->name('login-teachers');
Route::post('/login/students', [LoginController::class,'studentsLogin'])->name('login-students');
Route::post('/post-teacher-feeds', [FeedsController::class,'postTeacherFeeds'])->name('post-feeds-tchr');
Route::post('/post-student-feeds', [FeedsController::class,'postStudentFeeds'])->name('post-feeds-stdnt');
Route::post('/student-payment-charge', [HomeController::class,'studentPaymentCharge'])->name('student-charge');
Route::post('/teacher-create-stripe', [HomeController::class,'teacherCreateStripe'])->name('teacher-create-stripe');
Route::post('/approve-student-booking', [HomeController::class, 'approveStudentBooking'])->name('approval-booking');
Route::post('/student-book-free-trial', [HomeController::class, 'studentBookFreeTrial'])->name('student-booking-trial');
Route::post('/student-book-free-trial', [HomeController::class, 'studentBookFreeTrial'])->name('student-booking-trial');
Route::post('/upload-img', [UploadController::class, 'uploadImage']);
Route::post('/upload-badge', [UploadController::class, 'uploadBadge']);
Route::post('/remove-badge', [UploadController::class, 'removeBadge']);
Route::post('/post-likes', [FeedsController::class, 'postLikes']);
Route::post('/post-report', [FeedsController::class, 'postReport']);
Route::post('/post-comments', [FeedsController::class, 'postComments']);
Route::post('/get-teaching-strategy', [FeedsController::class, 'getLessonStrategyPlan']);

// Route::get('/todo', [TodoController::class, 'index']);
