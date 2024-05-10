<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AutherController;
use App\Http\Controllers\BorrowController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\EnrollmentController;
use App\Http\Controllers\NotificationController;

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


Route::post('/register',[AuthController::class,'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Routes accessible only to users
Route::middleware(['auth:sanctum', 'role:user'])->group(function () {

    // user profile
        Route::get('user/{user}', [UserController::class, 'show']);
        Route::put('update-user/{user}', [UserController::class, 'update']);


    // Notification
    Route::get('/notifications', [NotificationController::class, 'showUnreadNotification']);
    Route::put('/read_notification/{notification}', [NotificationController::class, 'markNotificationAsRead']);
});

// Routes accessible only to admins
Route::middleware(['auth:sanctum', 'role:admin'])->group(function () {
    
    // admin add book 
        Route::post('add-book', [BookController::class, 'store']);
        Route::put('update-book/{book}', [BookController::class, 'update']);
        Route::delete('delete-book/{book}', [BookController::class, 'destroy']);


    // auther
        Route::post('add-auther', [AutherController::class, 'store']);
        Route::put('update-auther/{auther}', [AutherController::class, 'update']);
        Route::delete('delete-auther/{auther}', [AutherController::class, 'destroy']);

});

// Routes accessible for admins and users
Route::middleware('auth:sanctum')->group(function () {
    
    // books routes
    Route::get('books', [BookController::class, 'index']);
    Route::get('book/{book}', [BookController::class, 'show']);

    
    // authers routes
        Route::get('authers', [AutherController::class, 'index']);
        Route::get('auther/{auther}', [AutherController::class, 'show']);

    // borrow book
    Route::post('/borrow-book', [BorrowController::class, 'borrowBook']);
    Route::post('/return-book', [BorrowController::class, 'returnBook']);
    Route::get('/user-books', [BorrowController::class, 'showUserBooks']);
    // Route::get('/user/books', [BorrowController::class, 'showUserBooks'])
    
    // review routes
    Route::get('/reviews',[ReviewController::class, 'index']);
    Route::post('/add-book-review/{book}',[ReviewController::class, 'storeBookReview']); // ###
    Route::post('/add-auther-review/{auther}',[ReviewController::class, 'storeAutherReview']);
    Route::get('/review/{review}',[ReviewController::class, 'show']);
    Route::put('/update-review/{review}',[ReviewController::class, 'update'])->middleware('is_reviewer');
    Route::delete('/delete-review/{review}',[ReviewController::class, 'destroy'])->middleware('delete_review');

    // review routes
    
    
});






