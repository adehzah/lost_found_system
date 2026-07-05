<?php

use Illuminate\Support\Facades\Route;

use App\Models\Student;
use App\Models\LostItem;
use App\Models\FoundItem;

use App\Http\Controllers\AdminController;
use App\Http\Controllers\StudentAuthController;
use App\Http\Controllers\LostItemController;
use App\Http\Controllers\FoundItemController;
use App\Http\Controllers\ClaimController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\ContactMessageController;

/*
|--------------------------------------------------------------------------
| Homepage
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    $currentStudent = null;

    if (session('student_id')) {
        $currentStudent = Student::find(session('student_id'));
    }

    $recentLostItems = LostItem::latest()->take(6)->get();
    $recentFoundItems = FoundItem::latest()->take(6)->get();

    $lostItemsCount = LostItem::count();
    $foundItemsCount = FoundItem::count();
    $claimedItemsCount = FoundItem::where('status', 'claimed')->count();

    return view('home', compact(
        'currentStudent',
        'recentLostItems',
        'recentFoundItems',
        'lostItemsCount',
        'foundItemsCount',
        'claimedItemsCount'
    ));
});


/*
|--------------------------------------------------------------------------
| Student Authentication
|--------------------------------------------------------------------------
*/

Route::get('/register', [StudentAuthController::class, 'registerPage']);
Route::post('/register', [StudentAuthController::class, 'register']);
Route::get('/register/verify', [StudentAuthController::class, 'registrationOtpPage']);
Route::post('/register/verify', [StudentAuthController::class, 'verifyRegistrationOtp']);
Route::post('/register/resend-otp', [StudentAuthController::class, 'resendRegistrationOtp']);

Route::get('/login', [StudentAuthController::class, 'loginPage']);
Route::post('/login', [StudentAuthController::class, 'login']);
Route::get('/forgot-password', [StudentAuthController::class, 'forgotPasswordPage']);
Route::post('/forgot-password', [StudentAuthController::class, 'requestPasswordResetOtp']);
Route::get('/forgot-password/verify', [StudentAuthController::class, 'passwordResetOtpPage']);
Route::post('/forgot-password/verify', [StudentAuthController::class, 'resetPassword']);
Route::post('/forgot-password/resend-otp', [StudentAuthController::class, 'resendPasswordResetOtp']);

Route::post('/logout', [StudentAuthController::class, 'logout']);

Route::get('/student/dashboard', [StudentAuthController::class, 'dashboard']);
Route::get('/notifications', [StudentAuthController::class, 'notifications']);
Route::post('/student/profile', [StudentAuthController::class, 'updateProfile']);
Route::get('/student/profile/verify', [StudentAuthController::class, 'profileOtpPage']);
Route::post('/student/profile/verify', [StudentAuthController::class, 'verifyProfileOtp']);
Route::post('/student/profile/resend-otp', [StudentAuthController::class, 'resendProfileOtp']);


/*
|--------------------------------------------------------------------------
| Lost Items
|--------------------------------------------------------------------------
*/

Route::get('/lost-items', [LostItemController::class, 'index']);
Route::get('/report-lost-item', [LostItemController::class, 'create']);
Route::post('/report-lost-item', [LostItemController::class, 'store']);
Route::get('/lost-items/{id}', [LostItemController::class, 'show']);
Route::post('/lost-items/{id}/delete', [LostItemController::class, 'destroy']);


/*
|--------------------------------------------------------------------------
| Found Items
|--------------------------------------------------------------------------
*/

Route::get('/found-items', [FoundItemController::class, 'index']);
Route::get('/report-found-item', [FoundItemController::class, 'create']);
Route::post('/report-found-item', [FoundItemController::class, 'store']);

Route::post('/found-items/{id}/claim', [ClaimController::class, 'store']);
Route::get('/found-items/{id}', [FoundItemController::class, 'show']);
Route::post('/found-items/{id}/delete', [FoundItemController::class, 'destroy']);


/*
|--------------------------------------------------------------------------
| Search
|--------------------------------------------------------------------------
*/

Route::get('/search', [SearchController::class, 'index']);


/*
|--------------------------------------------------------------------------
| Contact Admin
|--------------------------------------------------------------------------
*/

Route::get('/contact-admin', [ContactMessageController::class, 'create']);
Route::post('/contact-admin', [ContactMessageController::class, 'store']);


/*
|--------------------------------------------------------------------------
| Admin Authentication
|--------------------------------------------------------------------------
*/

Route::get('/admin', function () {
    return redirect('/admin/login');
});

Route::get('/admin/login', [AdminController::class, 'loginPage']);
Route::post('/admin/login', [AdminController::class, 'login']);
Route::post('/admin/logout', [AdminController::class, 'logout']);


/*
|--------------------------------------------------------------------------
| Admin Dashboard
|--------------------------------------------------------------------------
*/

Route::get('/admin/dashboard', [AdminController::class, 'dashboard']);


/*
|--------------------------------------------------------------------------
| Admin Claim Verification
|--------------------------------------------------------------------------
*/

Route::get('/admin/claims', [AdminController::class, 'claims']);
Route::get('/admin/claims/{id}', [AdminController::class, 'showClaim']);
Route::post('/admin/claims/{id}/approve', [AdminController::class, 'approveClaim']);
Route::post('/admin/claims/{id}/reject', [AdminController::class, 'rejectClaim']);


/*
|--------------------------------------------------------------------------
| Admin Management Pages
|--------------------------------------------------------------------------
*/

Route::get('/admin/users', [AdminController::class, 'users']);
Route::get('/admin/users/{id}', [AdminController::class, 'studentDetails']);
Route::post('/admin/users/{id}/delete', [AdminController::class, 'deleteStudent']);
Route::get('/admin/students', [AdminController::class, 'users']);

Route::get('/admin/messages', [AdminController::class, 'messages']);
Route::post('/admin/messages/{id}/read', [AdminController::class, 'markMessageRead']);
Route::post('/admin/messages/{id}/delete', [AdminController::class, 'deleteMessage']);
Route::get('/admin/reports', [AdminController::class, 'reports']);
