<?php

use App\Http\Controllers\AccountManagementController;
use App\Http\Controllers\AdminLowonganController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\LamaranController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\LowonganController;
use App\Http\Controllers\PerusahaanProfileController;
use App\Http\Controllers\PostLowonganController;
use App\Http\Controllers\RecruitmentController;
use App\Http\Controllers\ResumeController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\StatistikController;
use App\Http\Controllers\SuperAdminController;
use App\Http\Controllers\UserManagementController;
use App\Http\Controllers\UserProfileController;
use App\Models\Disabilitas;
use App\Models\Resume;
use Illuminate\Support\Facades\Route;

// Route::prefix('superadmin')
//     ->middleware(['auth:sanctum'])
//     ->group(function () {
//         // Disnaker Daerah
//         Route::post('/create-account-disnaker-daerah', [SuperAdminController::class, 'createAccountDisnakerDaerah']);
//         Route::post('/delete-account-disnaker-daerah/{id}', [SuperAdminController::class, 'deleteAccountDisnakerDaerah']);
//         Route::get('/get-account-disnaker-daerah', [SuperAdminController::class, 'getAccountDisnakerDaerah']);
//         Route::get('/get-account-by-id-disnaker-daerah/{id}', [SuperAdminController::class, 'getAccountByIdDisnakerDaerah']);
//         Route::post('/update-account-disnaker-daerah', [SuperAdminController::class, 'updateAccountDisnakerDaerah']);

//         // Perusahaan
//         Route::post('/create-account-perusahaan', [UserManagementController::class, 'createAccountPerusahaan']);
//         Route::post('/delete-account-perusahaan/{id}', [UserManagementController::class, 'deleteAccountPerusahaan']);
//         Route::get('/get-account-perusahaan', [UserManagementController::class, 'getAccountPerusahaan']);
//         Route::get('/get-account-by-id-perusahaan/{id}', [UserManagementController::class, 'getAccountByIdPerusahaan']);
//         Route::post('/update-account-perusahaan', [UserManagementController::class, 'updateAccountPerusahaan']);

//         // Kandidat
//         Route::post('/create-account-kandidat', [UserManagementController::class, 'createAccountKandidat']);
//         Route::post('/delete-account-kandidat/{id}', [UserManagementController::class, 'deleteAccountKandidat']);
//         Route::get('/get-account-kandidat', [UserManagementController::class, 'getAccountKandidat']);
//         Route::get('/get-account-by-id-kandidat/{id}', [UserManagementController::class, 'getAccountByIdKandidat']);
//         Route::post('/update-account-kandidat', [UserManagementController::class, 'updateAccountKandidat']);

//         // Role
//         Route::post('/create-role', [RoleController::class, 'createRole']);
//         Route::post('/assign-role', [RoleController::class, 'assignRoleToUser']);
//         Route::get('/get-role', [RoleController::class, 'getRole']);
//     });

// Route::prefix('admin')
//     ->middleware(['auth:sanctum'])
//     ->group(function () {
//         Route::get('/lowongan', [AdminLowonganController::class, 'index'])->middleware(['auth:sanctum']);
//         Route::post('/lowongan', [AdminLowonganController::class, 'store']);
//         Route::get('/lowongan/{id}', [AdminLowonganController::class, 'show']);
//         Route::put('/lowongan/{id}', [AdminLowonganController::class, 'update']);
//         Route::delete('/lowongan/{id}', [AdminLowonganController::class, 'destroy']);
//         Route::patch('/lowongan/{id}/status', [AdminLowonganController::class, 'updateStatus']);

//         // Perusahaan
//         Route::post('/create-account-perusahaan', [UserManagementController::class, 'createAccountPerusahaan']);
//         Route::post('/delete-account-perusahaan', [UserManagementController::class, 'deleteAccountPerusahaan']);
//         Route::get('/get-account-perusahaan', [UserManagementController::class, 'getAccountPerusahaan']);
//         Route::get('/get-account-by-id-perusahaan', [UserManagementController::class, 'getAccountByIdPerusahaan']);
//         Route::post('/update-account-perusahaan', [UserManagementController::class, 'updateAccountPerusahaan']);

//         // Kandidat
//         Route::post('/create-account-kandidat', [UserManagementController::class, 'createAccountKandidat']);
//         Route::post('/delete-account-kandidat', [UserManagementController::class, 'deleteAccountKandidat']);
//         Route::get('/get-account-kandidat', [UserManagementController::class, 'getAccountKandidat']);
//         Route::get('/get-account-by-id-kandidat', [UserManagementController::class, 'getAccountByIdKandidat']);
//         Route::post('/update-account-kandidat', [UserManagementController::class, 'updateAccountKandidat']);
//     });

// Route::prefix('admin')->group(function () {
//     Route::get('/lowongan', [AdminLowonganController::class, 'index'])->middleware(['auth:sanctum']);
//     Route::post('/lowongan', [AdminLowonganController::class, 'store']);
//     Route::get('/lowongan/{id}', [AdminLowonganController::class, 'show']);
//     Route::put('/lowongan/{id}', [AdminLowonganController::class, 'update']);
//     Route::delete('/lowongan/{id}', [AdminLowonganController::class, 'destroy']);
//     Route::patch('/lowongan/{id}/status', [AdminLowonganController::class, 'updateStatus']);
// });

// Route::prefix('perusahaan')->group(function () {
//     Route::get('lowongan', [PostLowonganController::class, 'index']);
//     Route::post('lowongan', [PostLowonganController::class, 'store']);
//     Route::put('lowongan/{id}', [PostLowonganController::class, 'update']);
//     Route::put('lowongan/{id}/ubah-status', [PostLowonganController::class, 'ubahStatus']);
//     Route::delete('lowongan/{id}', [PostLowonganController::class, 'destroy']);
//     Route::get('lowongan/filter', [PostLowonganController::class, 'filter']);
//     Route::get('lowongan/detail/{id}', [PostLowonganController::class, 'detailLowongan']);
//     Route::get('/lowongan/lihatLowongan', [PostLowonganController::class, 'LihatLowongan']);
//     Route::get('/lowongan/lihatPelamar', [LamaranController::class, 'lihatPelamar']);
//     // Route::get('/pelamar/{id}/detail-pelamar', [LamaranController::class, 'detailPelamar']);
//     Route::delete('/pelamar/{id}', [LamaranController::class, 'destroy']);
//     Route::put('/pelamar/{id}/status', [LamaranController::class, 'updateStatusPelamar']);
//     Route::get('/lowongan/{id}/pelamar', [lamaranController::class, 'daftarPelamar']);
// });

// Pelamar
// Route::post('/lowongan/{id}/daftar', [LamaranController::class, 'daftar']);

// Authentication Routes
Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);
Route::post('/refresh-csrf', [AuthController::class, 'refreshCsrf']);
Route::post('/forgot-password', [AuthController::class, 'forgotPassword']);

// Route::middleware('auth:sanctum')->group(function () {
//     Route::get('/user', [AuthController::class, 'user']);
//     Route::patch('/profile', [AuthController::class, 'updateProfile']);
//     Route::patch('/profile/update-avatar', [AuthController::class, 'updateAvatar']);
//     Route::post('/logout', [AuthController::class, 'logout']);
// });

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', [AuthController::class, 'user']);
    Route::put('/profile', [AuthController::class, 'updateProfile']);
    Route::put('/profile/update-avatar', [AuthController::class, 'updateAvatar']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/reset-password', [AuthController::class, 'resetPassword']);
});

// New Company Routes
Route::middleware(['auth:sanctum'])->prefix('company')
    ->group(function () {
        Route::post('job-vacancies', [PostLowonganController::class, 'store']);
        Route::get('/job-vacancies', [PostLowonganController::class, 'index']);
        Route::get('/job-vacancies/{id}', [PostLowonganController::class, 'show']);
        Route::delete('/job-vacancies/{id}', [PostLowonganController::class, 'destroy']);
        Route::get('/job-vacancies/{id}/applicant', [PostLowonganController::class, 'lihatPelamar']);

        // Update status of job vacancy
        Route::put('/job-vacancies/{id}/status', [PostLowonganController::class, 'updateStatus']);
        Route::put('/job-vacancies/{id}/status/reviewed', [PostLowonganController::class, 'updateStatusReviewed']);
    });

// Job Vacancies Routes no authentication
Route::prefix('jobs')
    ->group(function () {
        Route::get('/', [LowonganController::class, 'index']);
        Route::get('/{id}', [LowonganController::class, 'show']);
    });

Route::middleware(['auth:sanctum'])
    ->group(function () {
        Route::post('/apply-job/{id}', [LamaranController::class, 'lamarPekerjaan']);
        Route::get('/check-apply-status/{id}', [LamaranController::class, 'cekLamaran']);
        Route::get('/my-apply-jobs', [LamaranController::class, 'lamaranSaya']);
        Route::get('/check-user-profile', [LamaranController::class, 'cekUserProfile']);
    });

Route::prefix('perusahaan')
    ->middleware(['auth:sanctum'])
    ->group(function () {
        // Menampilkan profile perusahaan berdasarkan ID
        Route::get('/{id}', [PerusahaanProfileController::class, 'showPerusahaanProfile'])
            ->where('id', '[0-9]+');

        // Membuat profile perusahaan
        Route::post('/create', [PerusahaanProfileController::class, 'createPerusahaanProfile']);

        // Memperbarui profile perusahaan
        Route::put('/update', [PerusahaanProfileController::class, 'updatePerusahaanProfile']);
    });

// Baru
// Company profile routes
Route::prefix('perusahaan')
    ->middleware(['auth:sanctum'])
    ->group(function () {
        // Menampilkan profile perusahaan berdasarkan user yang login
        Route::get('/profile', [PerusahaanProfileController::class, 'showPerusahaanProfile']);

        // Membuat atau memperbarui profile perusahaan (single endpoint)
        Route::post('/profile', [PerusahaanProfileController::class, 'createOrUpdatePerusahaanProfile']);

        // Menghapus profile perusahaan
        Route::delete('/profile', [PerusahaanProfileController::class, 'deletePerusahaanProfile']);
    });

Route::prefix('user')
    ->middleware(['auth:sanctum'])
    ->group(function () {
        // Menampilkan user profile berdasarkan ID
        Route::get('/{id}', [UserProfileController::class, 'showUserProfile'])
            ->where('id', '[0-9]+');

        // Membuat user profile
        Route::post('/create', [UserProfileController::class, 'createUserProfile']);

        // Memperbarui user profile
        Route::put('/update', [UserProfileController::class, 'updateUserProfile']);

        // Pelamar
        Route::post('/lowongan/{id}/daftar', [LamaranController::class, 'daftar']);
    });

Route::middleware(['auth:sanctum'])
    ->group(function () {
        Route::get('/provinces', [LocationController::class, 'getProvince']);
        Route::get('/regencies', [LocationController::class, 'getRegencies']);
        Route::get('/districts', [LocationController::class, 'getDistricts']);
        Route::get('/villages', [LocationController::class, 'getVillages']);

        // Resume
        Route::post('/resume', [ResumeController::class, 'createResume']);
        Route::get('/resume/{id}', [ResumeController::class, 'getResume']);

        // Resume Location
        Route::post('/resume/lokasi', [ResumeController::class, 'createLokasi']);

        // Bahasa (Language)
        Route::post('/resume/bahasa', [ResumeController::class, 'createBahasa']);
        Route::get('/resume/bahasa', [ResumeController::class, 'getBahasa']);
        Route::put('/resume/bahasa', [ResumeController::class, 'updateBahasa']);
        Route::delete('/resume/bahasa', [ResumeController::class, 'deleteBahasa']);

        // Keterampilan (Skills)
        Route::post('/resume/keterampilan', [ResumeController::class, 'createKeterampilan']);
        Route::get('/resume/keterampilan', [ResumeController::class, 'getKeterampilan']);
        Route::put('/resume/keterampilan', [ResumeController::class, 'updateKeterampilan']);
        Route::delete('/resume/keterampilan', [ResumeController::class, 'deleteKeterampilan']);

        // Pendidikan (Education)
        Route::post('/resume/pendidikan', [ResumeController::class, 'createPendidikan']);
        Route::get('/resume/pendidikan', [ResumeController::class, 'getPendidikan']);
        Route::put('/resume/pendidikan', [ResumeController::class, 'updatePendidikan']);
        Route::delete('/resume/pendidikan', [ResumeController::class, 'deletePendidikan']);

        // Pencapaian (Achievement)
        Route::post('/resume/pencapaian', [ResumeController::class, 'createPencapaian']);
        Route::get('/resume/pencapaian', [ResumeController::class, 'getPencapaian']);
        Route::put('/resume/pencapaian', [ResumeController::class, 'updatePencapaian']);
        Route::delete('/resume/pencapaian', [ResumeController::class, 'deletePencapaian']);

        // Pelatihan (Training)
        Route::post('/resume/pelatihan', [ResumeController::class, 'createPelatihan']);
        Route::get('/resume/pelatihan', [ResumeController::class, 'getPelatihan']);
        Route::put('/resume/pelatihan', [ResumeController::class, 'updatePelatihan']);
        Route::delete('/resume/pelatihan', [ResumeController::class, 'deletePelatihan']);

        // Sertifikasi (Certification)
        Route::post('/resume/sertifikasi', [ResumeController::class, 'createSertfikasi']);
        Route::get('/resume/sertifikasi', [ResumeController::class, 'getSertfikasi']);
        Route::put('/resume/sertifikasi/{id}', [ResumeController::class, 'updateSertifikat']);
        Route::delete('/resume/sertifikasi', [ResumeController::class, 'deleteSertifikat']);

        // Pengalaman Kerja (Work Experience)
        Route::post('/resume/pengalaman-kerja', [ResumeController::class, 'createPengalamanKerja']);
        Route::get('/resume/pengalaman-kerja', [ResumeController::class, 'getPengalamanKerja']);
        Route::put('/resume/pengalaman-kerja/{id}', [ResumeController::class, 'updatePengalamanKerja']);
        Route::delete('/resume/pengalaman-kerja/{id}', [ResumeController::class, 'deletePengalamanKerja']);

        Route::delete('/resume/detele/cv', [ResumeController::class, 'deleteCV']);

        // Statistik
        Route::get('/statistik-total-lowongan', [StatistikController::class, 'getStatistikLowongan']);
        Route::get('/statistik-total-perusahaan', [StatistikController::class, 'getStatistikPerusahaan']);
        Route::get('/statistik-total-kandidat', [StatistikController::class, 'getStatistikKandidat']);
    });

// Management Account By Super Admin and Admin
Route::prefix('superadmin')
    ->middleware(['auth:sanctum'])
    ->group(function () {
        // Management Admin Role
        Route::get('/get-admin-role-by-location', [AccountManagementController::class, 'getAdminRoleByLocation']);
        Route::post('/create-admin-role-by-location', [AccountManagementController::class, 'createAdminRoleByLocation']);
        Route::delete('/delete-admin-role-by-location/{id}', [AccountManagementController::class, 'deleteAdminRoleByLocation']);
        Route::post('/admin-role-by-location/{id}/restore', [AccountManagementController::class, 'restoreAdminRoleByLocation']);
        Route::patch('/admin-role-by-location/{id}/update', [AccountManagementController::class, 'updateAdminRoleByLocation']);

        // Get Location By Admin Role
        Route::get('/get-regency-by-admin-role', [AccountManagementController::class, 'getRegenciesByAdminRole']);
    });

Route::prefix('account-management')
    ->middleware(['auth:sanctum'])
    ->group(function () {
        // Management Company Account
        Route::get('/get-company-by-location', [AccountManagementController::class, 'getCompanyByLocation']);
        Route::get('/show-company-by-location/{id}', [AccountManagementController::class, 'showCompanyByLocation']);
        Route::delete('/delete-company-by-location/{id}', [AccountManagementController::class, 'deleteCompanyByLocation']);

        // Management User Account
        Route::get('/get-user-profile-by-location', [AccountManagementController::class, 'getUserProfileByLocation']);
        Route::get('/show-user-profile-by-location/{id}', [AccountManagementController::class, 'showUserProfileByLocation']);
    });

Route::prefix('user-management')
    ->middleware(['auth:sanctum'])
    ->group(function () {
        // Get all user account and profile
        Route::get('/get-user-profile', [UserManagementController::class, 'getAccountKandidat']);
    });

Route::prefix('recruitment-job')
//    ->middleware(['auth:sanctum'])
    ->group(function () {
        Route::post('/invite', [RecruitmentController::class, 'sendRecruitmentToCandidate']);
        Route::post('/update-status-user', [RecruitmentController::class, 'updateUserRecruitmentStatus']);
        Route::post('/update-status-perusahaan', [RecruitmentController::class, 'updatePerusahaanRecruitmentStatus']);
        Route::get('/get', [RecruitmentController::class, 'getRecruitment']);
    });

// Route::get('/disability', function () {
//    return response()->json([
//        'status' => true,
//        'message' => 'Get data disability successfull',
//        'data' => Disabilitas::all()
//    ]);
// });

Route::prefix('/disability')
    ->group(function () {
        // Get disabilitas
        Route::get('/', [SuperAdminController::class, 'getDisabilitas']);
        // Create disabilitas baru
        Route::post('create-disability', [SuperAdminController::class, 'createDisabilitas']);
        // Update disabilitas
        Route::put('update-disability/{id}', [SuperAdminController::class, 'updateDisabilitas']);
        // Delete disabilitas
        Route::post('delete-disability/{id}', [SuperAdminController::class, 'deleteDisabilitas']);
    });
