<?php

use App\Domain\Category\Presentation\CategoryController;
use App\Domain\DataSKP\Presentation\DataSKPController;
use App\Domain\DataTraining\Presentation\DataTrainingController;
use App\Domain\DetailPerusahaan\Presentation\DetailPerusahaanController;
use App\Domain\DetailPeserta\Presentation\DetailPesertaController;
use App\Domain\Program\Presentation\ProgramController;
use App\Http\Controllers\Web\K3GeneralKemnakerRIController;
use App\Livewire\Settings\Appearance;
use App\Livewire\Settings\Password;
use App\Livewire\Settings\Profile;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/pendaftaran/k3-general-kemnaker-ri', [K3GeneralKemnakerRIController::class, 'index'])->name('k3.general.kemnaker.index');
Route::post('/pendaftaran/k3-general-kemnaker-ri', [K3GeneralKemnakerRIController::class, 'store'])->name('k3.general.kemnaker.store');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Route::get('settings/profile', Profile::class)->name('settings.profile');
    Route::get('settings/password', Password::class)->name('settings.password');
    Route::get('settings/appearance', Appearance::class)->name('settings.appearance');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('categories', [CategoryController::class, 'index'])->name('categories.index');
    Route::get('categories/create', [CategoryController::class, 'create'])->name('categories.create');
    Route::post('categories', [CategoryController::class, 'store'])->name('categories.store');
    Route::get('categories/{id}/edit', [CategoryController::class, 'edit'])->name('categories.edit');
    Route::put('categories/{id}', [CategoryController::class, 'update'])->name('categories.update');
    Route::delete('categories/{id}', [CategoryController::class, 'destroy'])->name('categories.destroy');
});

Route::middleware(['auth', 'verified'])->prefix('admin/detail-peserta')->group(function () {
    Route::get('/', [DetailPesertaController::class, 'index'])->name('detail_peserta.index');
    Route::get('create', [DetailPesertaController::class, 'create'])->name('detail_peserta.create');
    Route::post('/', [DetailPesertaController::class, 'store'])->name('detail_peserta.store');
    Route::get('{id}/edit', [DetailPesertaController::class, 'edit'])->name('detail_peserta.edit');
    Route::put('{id}', [DetailPesertaController::class, 'update'])->name('detail_peserta.update');
    Route::delete('{id}', [DetailPesertaController::class, 'destroy'])->name('detail_peserta.destroy');
});

Route::middleware(['auth', 'verified'])->prefix('admin/detail-peserta')->group(function () {
    Route::get('data-skp/{id}', [DataSKPController::class, 'show'])->name('data_skp.show');
    Route::post('data-skp/{id}', [DataSKPController::class, 'store'])->name('data_skp.store');
    Route::delete('data-skp/{id}', [DataSKPController::class, 'destroy'])->name('data_skp.destroy');

    Route::get('data-training/{id}', [DataTrainingController::class, 'show'])->name('data_training.show');
    Route::post('data-training/{id}', [DataTrainingController::class, 'store'])->name('data_training.store');
    Route::delete('data-training/{id}', [DataTrainingController::class, 'destroy'])->name('data_training.destroy');

    Route::get('detail-perusahaan/{detailPesertaId}', [DetailPerusahaanController::class, 'show'])->name('detail_perusahaan.show');
    Route::post('detail-perusahaan/{detailPesertaId}', [DetailPerusahaanController::class, 'store'])->name('detail_perusahaan.store');
    Route::delete('detail-perusahaan/{id}', [DetailPerusahaanController::class, 'destroy'])->name('detail_perusahaan.destroy');
});

Route::middleware(['auth', 'verified'])->prefix('admin/program')->group(function () {
    Route::get('/', [ProgramController::class, 'index'])->name('program.index'); // Menampilkan daftar program
    Route::get('/create', [ProgramController::class, 'create'])->name('program.create'); // Form tambah program
    Route::post('/store', [ProgramController::class, 'store'])->name('program.store'); // Simpan program baru
    Route::get('/edit/{id}', [ProgramController::class, 'edit'])->name('program.edit'); // Form edit program
    Route::put('/update/{id}', [ProgramController::class, 'update'])->name('program.update'); // Update program
    Route::post('/delete/{id}', [ProgramController::class, 'destroy'])->name('program.destroy'); // Hapus program
    Route::get('/{id}', [ProgramController::class, 'show'])->name('program.show');
    Route::get('/{id}/add-participants', [ProgramController::class, 'addParticipants'])->name('program.addParticipants');
    Route::post('/{id}/store-participants', [ProgramController::class, 'storeParticipants'])->name('program.storeParticipants');
    Route::delete('/peserta/delete/{id}', [ProgramController::class, 'removeParticipant'])->name('program.removeParticipant');
});

require __DIR__.'/auth.php';
