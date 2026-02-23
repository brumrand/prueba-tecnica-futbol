<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FavoriteTeamController;
use App\Http\Controllers\TeamController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Laravel\Fortify\Features;

Route::get('/', function () {
    return Inertia::render('welcome', [
        'canRegister' => Features::enabled(Features::registration()),
    ]);
})->name('home');

Route::get('dashboard', DashboardController::class)->middleware(['auth', 'verified'])->name('dashboard');

Route::post('favorite-teams/{teamId}', [FavoriteTeamController::class, 'store'])
    ->middleware(['auth'])
    ->name('favorite-teams.store');

Route::delete(
    'favorite-teams/{teamId}',
    [FavoriteTeamController::class, 'destroy']
)
    ->middleware(['auth'])
    ->name('favorite-teams.destroy');

require __DIR__ . '/settings.php';
