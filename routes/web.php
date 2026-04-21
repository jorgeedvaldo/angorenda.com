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

use App\Http\Controllers\HomeController;
use App\Http\Controllers\OwnerPropertyController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\PropertyController;
use Illuminate\Support\Facades\Artisan;

Route::get('/linkstorage', function () {
    Artisan::call('storage:link');
    return redirect()->back();
})->name('linkstorage');

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'authenticate']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/signup', [\App\Http\Controllers\Auth\RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/signup', [\App\Http\Controllers\Auth\RegisterController::class, 'register']);

Route::middleware(['auth'])->group(function () {
    Route::get('/minha-conta', [OwnerPropertyController::class, 'index'])->name('owner.dashboard');
    Route::get('/minha-conta/imoveis/criar', [OwnerPropertyController::class, 'create'])->name('owner.properties.create');
    Route::post('/minha-conta/imoveis', [OwnerPropertyController::class, 'store'])->name('owner.properties.store');
    Route::get('/minha-conta/imoveis/{property}/editar', [OwnerPropertyController::class, 'edit'])->name('owner.properties.edit');
    Route::put('/minha-conta/imoveis/{property}', [OwnerPropertyController::class, 'update'])->name('owner.properties.update');
    Route::delete('/minha-conta/imoveis/{property}', [OwnerPropertyController::class, 'destroy'])->name('owner.properties.destroy');
    Route::delete('/minha-conta/imagens/{image}', [OwnerPropertyController::class, 'destroyImage'])->name('owner.images.destroy');
});

Route::get('/imoveis', [PropertyController::class, 'index'])->name('properties.index');
Route::get('/imoveis/{slug}', [PropertyController::class, 'show'])->name('properties.show');
