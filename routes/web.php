<?php

use App\Http\Controllers\AiringController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CinemaController;
use App\Http\Controllers\MovieController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\ShowingController;
use App\Http\Controllers\UserController;
use App\Models\Showing;
use Illuminate\Support\Facades\Route;

Route::get('/', [PageController::class, "index"])->name('home');
Route::get('/profile', [PageController::class, "profile"])->name('profile');
Route::get('/movies/all', [PageController::class, "allMovies"])->name('movie.all');
Route::get('/movie/{id}/airings', [PageController::class, "showMovie"])->name('page.movie');
Route::get('/about', [PageController::class, "about"])->name('about');
Route::get('/contact', [PageController::class, "contact"])->name('contact');


Route::middleware(['auth'])->group(function () {

    Route::get('/movie/{id1}/airing/{id2}', [PageController::class, 'showTicketOverview'])->name('ticket.overview');
    Route::post('/movie/{id1}/airing/{id2}', [PageController::class, 'submitTicket'])->name('ticket.submit');
    Route::post('/movie/{id}/favorite/add', [PageController::class, 'addToFavorite'])->name('movie.favorite');
    Route::delete('/movie/{id}/favorite/add', [PageController::class, 'addToFavorite'])->name('movie.favorite');
    Route::post('/logout', [AuthController::class, "logout"])->name('logout');

    Route::middleware('role:admin')->group(function () {
        Route::get('/dashboard/cinemas', [CinemaController::class, "index"])->name('dashboard');
        Route::resource('/dashboard/cinemas', CinemaController::class)->except('index');
        Route::resource('/dashboard/movies', MovieController::class);
        Route::resource('/dashboard/showings', ShowingController::class);
        Route::resource('/dashboard/airings', AiringController::class);
        Route::resource('/dashboard/categories', CategoryController::class);
        Route::resource('/dashboard/rooms', RoomController::class);
        Route::resource('/dashboard/users', UserController::class);
        Route::get('/rooms/{cinema_id}', [RoomController::class, 'getRoomsByCinema']);
        Route::get('/showings/{id}', [ShowingController::class, 'getShowingPeriod']);
        Route::get('/occupied-times', [AiringController::class, 'occupiedTimes']);
    });

});

Route::middleware('guest')->group(function (){
    Route::get('/login', [AuthController::class, "loginView"])->name('loginView');
    Route::post('/login', [AuthController::class, "login"])->name('login');
    Route::get('/register', [AuthController::class, "registerView"])->name('registerView');
    Route::post('/register', [AuthController::class, "register"])->name('register');
});
