<?php
use App\Http\Controller\Api\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);

Route::post('logout', [AuthController::class, 'logout'])->middleware('auth:sanctum') ;

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:sanctum')->group(function () {
    Route::resource('customers', CustomerController::class);
});
Route::middleware('auth:sanctum')->group(function () {
    Route::resource('blog-posts', BlogPostController::class);
});

Route::get('blog-posts/{postId}/comments', [CommentController::class, 'index']);
Route::get('/api/blog-posts/{id}', [BlogPostController::class, 'show']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('blog-posts/{postId}/comments', [CommentController::class, 'store']);
});
