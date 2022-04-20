<?php

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
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\FeedsController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\UploadController;
use App\Mail\RegisterMail;

Route::get('/', [HomeController::class, 'index']);

Route::get('/teacher-dashboard', function () {
    return view('teacher-dashboard');
});


Auth::routes();

// GET
Route::get('/login/teachers', [LoginController::class, 'showTeachersLoginForm']);
Route::get('/login/students', [LoginController::class,'showStudentsLoginForm']);
Route::get('/admins-login', [LoginController::class,'showAdminsLoginForm']);
Route::get('/register/teachers', [RegisterController::class, 'showTeachersRegisterForm']);
Route::get('/register/students', [RegisterController::class,'showStudentsRegisterForm']);
Route::get('/get-countries', [HomeController::class,'getCountries']);

// POST
Route::post('/login/teachers', [LoginController::class,'teachersLogin']);
Route::post('/login/students', [LoginController::class,'studentsLogin']);
Route::post('/login/admins', [LoginController::class,'adminsLogin']);

Route::post('/register/teachers', [RegisterController::class,'createTeachers']);
Route::post('/register/students', [RegisterController::class,'createStudents']);
Route::post('/update-teacher-settings', [HomeController::class,'updateTeacherSettings']);
Route::post('/update-teacher-profile-settings', [HomeController::class,'updateTeacherProfileSettings']);
Route::post('/update-student-settings', [HomeController::class,'updateStudentSettings']);
Route::post('/get-teachers-details', [HomeController::class,'getTeachersDetails']);
Route::post('/get-students-details', [HomeController::class,'getStudentsDetails']);
Route::post('/get-time-available-per-day', [HomeController::class, 'getATimeAvailablePerDay']);
Route::post('/get-week-calendar', [HomeController::class, 'getAWeekCalendar']);
Route::post('/get-booked-student-info', [HomeController::class, 'getBookedStudentInfo']);
Route::get('/get-students-info/{any}', [HomeController::class, 'getStudentsInfo']);
Route::get('/verifying-student-email/{email}', [RegisterController::class, 'verifyingStudentEmail']);
Route::get('/verifying-teacher-email/{email}', [RegisterController::class, 'verifyingTeacherEmail']);
Route::get('/view-reg-template', [RegisterController::class, 'viewRegTemplate']);



/**
 * Routes for mailing
 */
Route::get('/email/{email}', function($email){
    Mail::to($email)->send(new RegisterMail());
    return new RegisterMail();
});


Route::group(['middleware' => 'auth:admins'], function () {
    // Route::get('/admins', [AdminController::class, 'adminsDashboard']);
    // Route::get('/admins/student-payments', [AdminController::class, 'studentPayment']);
    Route::get('/admins/heygo-wallet', [AdminController::class, 'heygoWallet']);
    // Route::get('/admins/teacher-wallet', [AdminController::class, 'teacherWallet']);
    Route::get('/admins/badge-list', [AdminController::class, 'badgeList']);
    Route::get('/admins/teachers-list-setup', [AdminController::class, 'teachersListSetup']);
    Route::post('/get-lesson-and-badges', [AdminController::class, 'getLessonAndBadge']);
    Route::get('/get-student-payment-transaction', [AdminController::class, 'getPaymentTransactionStudent']);
    Route::get('/get-teacher-payment-transaction', [AdminController::class, 'getPaymentTransactionTeacher']);
    Route::get('/get-heygo-wallet', [AdminController::class, 'getHeygoWallet']);

    // Route::get('/settings-panel', [AdminController::class, 'adminsDashboard']);
    // Route::get('/admin/{any}', [AdminController::class, 'adminsDashboard'])->where('any', '.*');
    Route::get('/admins', [AdminController::class, 'adminsDashboard']);
    Route::get('/admins/{any}', [AdminController::class, 'adminsDashboard'])->where('any', '.*');

});


Route::group(['middleware' => 'auth:students'], function () {
    // Route::view('/students', 'students');
    Route::get('/students', [HomeController::class, 'studentsDashboard']);
    Route::get('/teachers-profile/{any}', [HomeController::class, 'teachersProfile']);
    Route::get('/get-teachers-info/{any}', [HomeController::class, 'getTeachersInfo']);
    Route::post('/get-lesson-option', [HomeController::class, 'getLessonOption']);
    Route::get('/students-account-settings', [HomeController::class, 'studentsAccountSettings']);
    Route::get('/students-payment-methods', [HomeController::class, 'studentsPaymentMethods']);
    Route::post('/save-student-bank-acct', [HomeController::class, 'saveStudentBankAcct']);
    Route::get('/get-com-app', [HomeController::class, 'getCommunicationApp']);
    Route::post('/save-email-communication', [HomeController::class, 'saveEmailCommunication']);
    Route::post('/get-teacher-booked-lesson', [HomeController::class, 'getTeacherBookedLesson']);
    Route::post('/get-booked-teacher-info', [HomeController::class, 'getBookedTeacherInfo']);
    Route::get('/get-students-level', [HomeController::class, 'getStudentsLevel']);
    Route::get('/get-lesson-type-details', [HomeController::class, 'getLessonTypeDetails']);
    Route::get('/get-test-student-preparation', [HomeController::class, 'getTestStudentPreparation']);
    Route::get('/get-students-english-level', [HomeController::class, 'getStudentsEnglishLevel']);
    Route::get('/get-students-date-plan', [HomeController::class, 'getStudentsDatePlan']);
    Route::post('/save-student-pref', [HomeController::class, 'saveStudentPref']);
    Route::post('/update-student-schedule', [HomeController::class, 'updateStudentSchedule']);
    Route::get('/students-purchase-history', [HomeController::class, 'studentsPurchaseHistory']);
    Route::get('/start-chat-students/{any}', [ChatController::class, 'startChat']);
    Route::post('/messages-students', [ChatController::class, 'message']);
    Route::post('/get-conversation-students', [ChatController::class, 'getConversation']);
    Route::get('/student-feeds', [HomeController::class, 'studentFeeds']);
    Route::post('/display-student-feeds', [FeedsController::class, 'displayStudentFeeds']);
});

Route::group(['middleware' => 'auth:teachers'], function () {
    // Route::view('/teachers', 'teachers');
    Route::get('/teachers', [HomeController::class, 'teachersDashboard']);
    Route::get('/teachers/{any}', [HomeController::class, 'teachersDashboard']);
    Route::get('/teachers-account-settings', [HomeController::class, 'teachersAccountSettings']);
    Route::get('/teachers-profile-main', [HomeController::class, 'teachersDashboard']);
    Route::get('/get-lesson-type-rate', [HomeController::class, 'getLessonTypeRate']);
    Route::get('/get-lesson-plan', [HomeController::class, 'getLessonPlan']);
    Route::get('/teacher-lobby-lesson-plan', [FeedsController::class, 'getLessonPlan']);
    Route::get('/students-level', [FeedsController::class, 'getStudentsLevel']);
    Route::get('/get-curreny-rate', [HomeController::class, 'getCurrenyRate']);
    Route::post('/get-student-booked-lesson', [HomeController::class, 'getStudentBookedLesson']);
    Route::get('/teachers-payment-methods', [HomeController::class, 'teachersPaymentMethods']);
    Route::post('/display-teacher-feeds', [FeedsController::class, 'displayTeacherFeeds']);
    Route::get('/display-teacher-calendar', [HomeController::class, 'displayTeacherCalendar']);
    Route::get('/get-teachers-availability', [HomeController::class, 'getTeachersAvailability']);
    Route::post('/save-teacher-availability', [HomeController::class, 'saveTeacherAvailability']);
    Route::get('/teachers-purchase-history', [HomeController::class, 'teachersPurchaseHistory']);
    Route::get('/start-chat-teachers/{any}', [ChatController::class, 'startChat']);
    Route::post('/messages-teachers', [ChatController::class, 'message']);
    Route::post('/get-conversation-teachers', [ChatController::class, 'getConversation']);
    Route::post('/update-default-dp', [UploadController::class, 'updateDefaultDp']);
    Route::get('/profile-feeds/{any}/{feeds_id}', [FeedsController::class, 'profileFeeds']);
    Route::post('/get-teacher-schedule', [HomeController::class, 'getTeacherSchedule']);
    Route::post('/save-teaching-strategy', [FeedsController::class, 'saveTeachingStrategy']);
    Route::post('/get-teaching-strategy/{any}', [FeedsController::class, 'getLessonStrategyPlan']);
    Route::post('/teachers-reset-password', [HomeController::class, 'teachersResetPassword']);

    Route::post('/upload-workbook', [HomeController::class, 'uploadWorkbook'],function(Request $request){});

});
Route::post('/save-bookmark', [FeedsController::class, 'saveBookmark']);
Route::post('/save-ratings-per-strat-plan', [FeedsController::class, 'saveRatingsPerStratPlan']);


// Route::post('/get-teaching-strategy', [FeedsController::class, 'getLessonStrategyPlan']);


Route::get('logout', [LoginController::class,'logout']);