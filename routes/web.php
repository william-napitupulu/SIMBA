<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AbsensiController;
use App\Http\Controllers\DosenController;
use App\Http\Controllers\KemahasiswaanController;
use App\Http\Controllers\KonselorController;
use App\Http\Controllers\KeasramaanController;
use App\Http\Controllers\OrangTuaController;
use App\Http\Controllers\ProfilController;
use App\Http\Controllers\CalendarController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\PasswordResetController;
use App\Http\Controllers\SetPerwalianController;
use App\Http\Controllers\DaftarPelanggaranController;
use App\Http\Controllers\AjukanKonselingController;
use App\Http\Controllers\RiwayatKonselingController;
use App\Http\Controllers\HasilKonselingController;
use App\Http\Controllers\DaftarRequestKonselingController;
use App\Http\Controllers\CatatanPerilakuDetailController;
use App\Http\Controllers\SmsController;

// Login dan Logout
Route::get('/', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

// Register
Route::get('/register', [RegisterController::class, 'showRegisterForm'])->name('register.form');
Route::post('/register', [RegisterController::class, 'submitRegistration'])->name('register.submit');
Route::get('/activate', [RegisterController::class, 'showActivationForm'])->name('activation.prompt');
Route::post('/activate', [RegisterController::class, 'activateAccount'])->name('activation.submit');

// Password Reset
Route::get('/forgot-password', [PasswordResetController::class, 'showForgotPasswordForm'])->name('password.forgot');
Route::post('/forgot-password', [PasswordResetController::class, 'sendResetLink'])->name('password.send-link');
Route::get('/reset-password/{token}', [PasswordResetController::class, 'showResetPasswordForm'])->name('password.reset.form');
Route::post('/reset-password', [PasswordResetController::class, 'resetPassword'])->name('password.reset');
Route::get('/waiting-email', function () {
    return view('auth.waiting-email');
})->name('password.waiting-email');


// Middleware untuk kemahasiswaan
Route::middleware(['auth.session', 'role:kemahasiswaan'])->group(function () {
    Route::get('/kemahasiswaan/beranda', [KemahasiswaanController::class, 'index'])->name('kemahasiswaan');
    Route::post('/kemahasiswaan/beranda/store', [KemahasiswaanController::class, 'store'])->name('pengumuman.store');
    Route::delete('/kemahasiswaan/beranda/{id}', [KemahasiswaanController::class, 'destroy'])->name('pengumuman.destroy');
    Route::get('/kemahasiswaan/pengumuman/{id}', [KemahasiswaanController::class, 'show'])->name('pengumumankemahasiswaan.detail');
    Route::post('/calendar/upload', [CalendarController::class, 'upload'])->name('calendar.upload');

    // Konseling
    Route::prefix('konseling')->group(function () {
        Route::get('/kemahasiswaan/daftar_pelanggaran', [DaftarPelanggaranController::class, 'daftarPelanggaran'])->name('daftar_pelanggaran_kemahasiswaan');
        Route::get('/kemahasiswaan/hasil_konseling', [KemahasiswaanController::class, 'hasilKonseling'])->name('hasil_konseling_kemahasiswaan');
        Route::get('/kemahasiswaan/riwayat_konseling', [RiwayatKonselingController::class, 'index'])->name('riwayat_konseling_kemahasiswaan');
        Route::get('/kemahasiswaan/konseling_lanjutan', [KemahasiswaanController::class, 'konselingLanjutan'])->name('konseling_lanjutan_kemahasiswaan');
        Route::get('/kemahasiswaan/ajukan_konseling', [KemahasiswaanController::class, 'ajukanKonseling'])->name('ajukan_konseling_kemahasiswaan');
        
        // Daftar request kemahasiswaan
        Route::get('/kemahasiswaan/daftar-request', [DaftarRequestKonselingController::class, 'daftarRequest'])->name('daftar_request');
        Route::put('/kemahasiswaan/approve-konseling/{id}', [DaftarRequestKonselingController::class, 'approve'])->name('approve_konseling');
        Route::put('/kemahasiswaan/reject-konseling/{id}', [DaftarRequestKonselingController::class, 'reject'])->name('reject_konseling');

        Route::get('/hasil', [HasilKonselingController::class, 'index'])->name('hasil.index');
        Route::post('/hasil-konseling', [HasilKonselingController::class, 'store'])->name('hasil_konseling.store');
        Route::get('/hasil/{id}', [HasilKonselingController::class, 'show'])->name('hasil.show');
        Route::delete('/hasil/{id}', [HasilKonselingController::class, 'destroy'])->name('hasil.destroy');

        Route::prefix('konseling')->group(function () {
            Route::get('/ajukan', [AjukanKonselingController::class, 'index'])->name('konseling.ajukan');
            Route::get('/cari', [AjukanKonselingController::class, 'cariMahasiswa'])->name('konseling.cari');
            Route::post('/submit', [AjukanKonselingController::class, 'submit'])->name('konseling.ajukan');
            Route::get('/caririwayat', [RiwayatKonselingController::class, 'CariRiwayatMahasiswa'])->name('konseling.caririwayat');
            // Menampilkan semua riwayat konseling mahasiswa
            Route::get('/riwayat-konseling', [RiwayatKonselingController::class, 'index'])->name('riwayat.konseling.kemahasiswaan');
            Route::post('/hasil-konseling/upload', [HasilKonselingController::class, 'upload'])->name('hasil_konseling.upload');

            // Mencari riwayat konseling mahasiswa berdasarkan NIM
            Route::get('/riwayat-konseling/cari', [RiwayatKonselingController::class, 'CariRiwayatMahasiswa'])->name('riwayat.konseling.cari');
        });
    });
});

// Middleware untuk konselor
Route::middleware(['auth.session', 'role:konselor'])->group(function () {
    Route::get('/konselor/beranda', [KonselorController::class, 'index'])->name('konselor');
    Route::post('/konselor/beranda/store', [KonselorController::class, 'store'])->name('pengumuman.store');
    Route::delete('/konselor/beranda/{id}', [KonselorController::class, 'destroy'])->name('pengumuman.destroy');
    Route::get('/konselor/pengumuman/{id}', [KonselorController::class, 'show'])->name('pengumunankonselor.detail');
    Route::post('/calendar/upload', [CalendarController::class, 'upload'])->name('calendar.upload');

    // Konseling
    Route::prefix('konseling')->group(function () {
        Route::get('/konselor/daftar_pelanggaran', [DaftarPelanggaranController::class, 'daftarPelanggaran'])->name('daftar_pelanggaran_konselor');
        Route::get('/konselor/hasil_konseling', [KonselorController::class, 'hasilKonseling'])->name('hasil_konseling_konselor');
        Route::get('/konselor/riwayat_konseling', [RiwayatKonselingController::class, 'index'])->name('riwayat_konseling_konselor');
        Route::get('/konselor/konseling_lanjutan', [KonselorController::class, 'konselingLanjutan'])->name('konseling_lanjutan_konselor');
        Route::get('/konselor/ajukan_konseling', [KonselorController::class, 'ajukanKonseling'])->name('ajukan_konseling_konselor');
        
        // Daftar request konselor
        Route::get('/konselor/daftar-request', [DaftarRequestKonselingController::class, 'daftarRequest'])->name('daftar_request');
        Route::put('/konselor/approve-konseling/{id}', [DaftarRequestKonselingController::class, 'approve'])->name('approve_konseling');
        Route::put('/konselor/reject-konseling/{id}', [DaftarRequestKonselingController::class, 'reject'])->name('reject_konseling');

        Route::get('/hasil', [HasilKonselingController::class, 'index'])->name('hasil.index');
        Route::post('/hasil-konseling', [HasilKonselingController::class, 'store'])->name('hasil_konseling.store');
        Route::get('/hasil/{id}', [HasilKonselingController::class, 'show'])->name('hasil.show');
        Route::delete('/hasil/{id}', [HasilKonselingController::class, 'destroy'])->name('hasil.destroy');

        Route::prefix('konseling')->group(function () {
            Route::get('/ajukan', [AjukanKonselingController::class, 'index'])->name('konseling.ajukan');
            Route::get('/cari', [AjukanKonselingController::class, 'cariMahasiswa'])->name('konseling.cari');
            Route::post('/submit', [AjukanKonselingController::class, 'submit'])->name('konseling.ajukan');
            Route::get('/caririwayat', [RiwayatkonselingController::class, 'CariRiwayatMahasiswa'])->name('konseling.caririwayat');
            // Menampilkan semua riwayat konseling mahasiswa
            Route::get('/riwayat-konseling', [RiwayatKonselingController::class, 'index'])->name('riwayat.konseling.konselor');
            Route::post('/hasil-konseling/upload', [HasilKonselingController::class, 'upload'])->name('hasil_konseling.upload');

            // Mencari riwayat konseling mahasiswa berdasarkan NIM
            Route::get('/riwayat-konseling/cari', [RiwayatKonselingController::class, 'CariRiwayatMahasiswa'])->name('riwayat.konseling.cari');
        });
    });
});

// Middleware untuk dosen
Route::middleware(['auth.session', 'role:dosen'])->group(function () {
    Route::get('/dosen/beranda', [DosenController::class, 'beranda'])->name('dosen');
    Route::get('/dosen/perwalian', [DosenController::class, 'index'])->name('dosen.perwalian');
    Route::get('/dosen/presensi', [DosenController::class, 'presensi'])->name('dosen.presensi');
    Route::get('/dosen/absensi-mahasiswa', [AbsensiController::class, 'index'])->name('absensi');

    Route::get('/absensi-mahasiswa/{date}/{class}', [AbsensiController::class, 'show'])->name('absensi.show');
    Route::get('/set-perwalian', [SetPerwalianController::class, 'index'])->name('set.perwalian');
    Route::post('/set-perwalian', [SetPerwalianController::class, 'store'])->name('set.perwalian.store');
});

// Middleware untuk keasramaan
Route::middleware(['auth.session', 'ensure.student.data.all.student', 'role:keasramaan'])->group(function () {
    Route::get('/keasramaan/beranda', [KeasramaanController::class, 'index'])->name('keasramaan');
    Route::get('/keasramaan/catatan-perilaku', [KeasramaanController::class, 'pelanggaran'])->name('pelanggaran_keasramaan');
    Route::get('/keasramaan/catatan-perilaku/detail/{studentNim}', [KeasramaanController::class, 'detail'])->name('catatan_perilaku_detail');

    Route::prefix('student-behaviors')->group(function () {
        Route::get('/create/{studentNim}/{ta}/{semester}', [CatatanPerilakuDetailController::class, 'create'])
            ->name('student_behaviors.create');

        Route::post('/store', [CatatanPerilakuDetailController::class, 'store'])
            ->name('student_behaviors.store');

        Route::get('/{id}/edit', [CatatanPerilakuDetailController::class, 'edit'])
            ->name('student_behaviors.edit');

        Route::post('/{id}/update', [CatatanPerilakuDetailController::class, 'update']) ->name('student_behaviors.update');

        Route::delete('/{id}/destroy', [CatatanPerilakuDetailController::class, 'destroy'])
            ->name('student_behaviors.destroy');
    });

});

// Middleware untuk orang tua
Route::middleware(['auth.session', 'ensure.student.data.ortu', 'role:orang_tua'])->group(function () {
    Route::get('/profil', [ProfilController::class, 'index'])->name('profil');
    Route::get('/orang_tua/beranda', [OrangTuaController::class, 'index'])->name('orang_tua');
    Route::get('/orang_tua/catatan_perilaku', [OrangTuaController::class, 'catatan_perilaku'])->name('catatan_perilaku_orang_tua');
});

Route::post('/send-sms', [SmsController::class, 'send']);
Route::get('/send-sms', [SmsController::class, 'create']);