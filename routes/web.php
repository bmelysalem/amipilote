<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('dashboard');
});
Route::middleware(['auth'])->group(function () {
    Route::get('programmes/{programme}/abonnes/{abonne}/pdf', [App\Http\Controllers\ProgrammesDetController::class, 'generatePdf'])->name('fichier-pose.pdf');
    Route::get('programmes/{programme}/generate-fiches', [App\Http\Controllers\ProgrammesDetController::class, 'generateFiches'])->name('generate-fiches');
    Route::post('programmes/{programme}/valider', [App\Http\Controllers\ProgrammesController::class, 'valider'])->name('programmes.valider');
    Route::get('programmes/{programme}/download-fiches2', [App\Http\Controllers\ProgrammesDetController::class, 'downloadFiches'])->name('download-fiches2');
    Route::get('programmes/{programme}/download-table', [App\Http\Controllers\ProgrammesDetController::class, 'downloadTable'])->name('download-table');
    Route::resource('programmes', App\Http\Controllers\ProgrammesController::class);
    Route::resource('services', App\Http\Controllers\ServiceController::class);
    Route::get('/search-abonnees', [App\Http\Controllers\AbonnesController::class, 'search'])->name('search.abonnees');
    Route::post('/programmes/{programme}/add-programmedet', [App\Http\Controllers\ProgrammesController::class, 'addProgrammeDet'])->name('add.programmedet');
    Route::post('/programmes/{programme}/add-all-programmedet', [App\Http\Controllers\ProgrammesController::class, 'addAllProgrammesDet'])->name('add.all.programmedet');
    Route::post('/programmes/{programmeId}/changements', [App\Http\Controllers\ProgrammesController::class, 'storeChangementsLocal'])->name('programmes.storeChangementsLocal');
    Route::delete('/programmes/{programmeId}/programmedet/{programmedetId}', [App\Http\Controllers\ProgrammesController::class, 'deleteProgrammeDet'])->name('programmes.deleteProgrammesDet');
    Route::post('/generate-fiches-list', [App\Http\Controllers\ProgrammesDetController::class, 'generateFichesByList'])->name('generateFichesByList');

    //service cle
    Route::get('/calculate-key', [App\Http\Controllers\KeyCalculationController::class, 'calculateForm']);
    Route::post('/calculate-key', [App\Http\Controllers\KeyCalculationController::class, 'calculate']);

});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
