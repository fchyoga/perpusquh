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
Route::get('', [App\Http\Controllers\CustomAuthController::class, 'welcome'])->name('welcome');
Route::get('/book/{title}', [App\Http\Controllers\CustomAuthController::class, 'getDetail'])->name('getDetail');
Route::get('/search', [App\Http\Controllers\BookController::class, 'searchPublic'])->name('book-management');
Route::get('/login', [App\Http\Controllers\CustomAuthController::class, 'index'])->name('login');
Route::post('custom-login', [App\Http\Controllers\CustomAuthController::class, 'customLogin'])->name('login.custom');
Route::get('register', [App\Http\Controllers\CustomAuthController::class, 'registration'])->name('register-user');
Route::post('custom-registration', [App\Http\Controllers\CustomAuthController::class, 'customRegistration'])->name('register.custom');
Route::post('logout', [App\Http\Controllers\CustomAuthController::class, 'signOut'])->name('logout');

// admin route
// order management
Route::get('/dashboard', [App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard')->middleware(['role:admin']);

// book management
Route::get('/dashboard/book-management', [App\Http\Controllers\BookController::class, 'index'])->name('book-management')->middleware(['role:admin']);
Route::get('/dashboard/book-management/create', [App\Http\Controllers\BookController::class, 'create'])->name('book-management.create')->middleware(['role:admin']);
Route::post('/dashboard/book-management/store', [App\Http\Controllers\BookController::class, 'store'])->name('book-store')->middleware(['role:admin']);
Route::get('/dashboard/book-management/delete/{book_id}', [App\Http\Controllers\BookController::class, 'destroy'])->name('book-delete')->middleware(['role:admin']);
Route::get('/dashboard/book-management/search', [App\Http\Controllers\BookController::class, 'search'])->name('book-management.search')->middleware(['role:admin']);
Route::get('/dashboard/book-management/{book_id}', [App\Http\Controllers\BookController::class, 'edit'])->name('book-management.edit')->middleware(['role:admin']);
Route::put('/dashboard/book-management/update/{book_id}', [App\Http\Controllers\BookController::class, 'update'])->name('book-management.update')->middleware(['role:admin']);

// user management
Route::get('/dashboard/student-management', [App\Http\Controllers\MemberController::class, 'index'])->name('student-management')->middleware(['role:admin']);
Route::post('/dashboard/student-management/import', [App\Http\Controllers\MemberController::class, 'import'])->name('student-management.import')->middleware(['role:admin']);
Route::get('/dashboard/student-management/create', [App\Http\Controllers\MemberController::class, 'create'])->name('student-management.create')->middleware(['role:admin']);
Route::post('/dashboard/student-management/store', [App\Http\Controllers\MemberController::class, 'store'])->name('student-store')->middleware(['role:admin']);
Route::get('/dashboard/student-management/delete/{student_id}', [App\Http\Controllers\MemberController::class, 'destroy'])->name('student-delete')->middleware(['role:admin']);
Route::get('/dashboard/student-management/search', [App\Http\Controllers\MemberController::class, 'search'])->name('student-management.search')->middleware(['role:admin']);
Route::get('/dashboard/student-management/{student_id}', [App\Http\Controllers\MemberController::class, 'edit'])->name('student-management.edit')->middleware(['role:admin']);
Route::put('/dashboard/student-management/update/{student_id}', [App\Http\Controllers\MemberController::class, 'update'])->name('student-management.update')->middleware(['role:admin']);

// loan management
Route::get('/dashboard/loan-management', [App\Http\Controllers\LoanController::class, 'index'])->name('loan-management')->middleware(['role:admin']);
Route::get('/dashboard/loan-management/create', [App\Http\Controllers\LoanController::class, 'create'])->name('loan-management.create')->middleware(['role:admin']);
Route::post('/dashboard/loan-management/store', [App\Http\Controllers\LoanController::class, 'store'])->name('loan-store')->middleware(['role:admin']);
Route::get('/dashboard/loan-management/search', [App\Http\Controllers\LoanController::class, 'search'])->name('loan-management.search')->middleware(['role:admin']);
Route::get('/dashboard/loan-management/download', [App\Http\Controllers\LoanController::class, 'download'])->name('loan-management.download')->middleware(['role:admin']);
Route::get('/dashboard/loan-management/{loan_id}', [App\Http\Controllers\LoanController::class, 'edit'])->name('loan-management.edit')->middleware(['role:admin']);
Route::put('/dashboard/loan-management/update/{loan_id}', [App\Http\Controllers\LoanController::class, 'update'])->name('loan-management.update')->middleware(['role:admin']);
Route::get('/dashboard/loan-management/approve/{loan_id}', [App\Http\Controllers\LoanController::class, 'approve'])->name('loan-approve')->middleware(['role:admin']);
Route::get('/dashboard/loan-management/accept/{loan_id}', [App\Http\Controllers\LoanController::class, 'accept'])->name('loan-accept')->middleware(['role:admin']);
Route::get('/dashboard/loan-management/reject/{loan_id}', [App\Http\Controllers\LoanController::class, 'reject'])->name('loan-reject')->middleware(['role:admin']);

// profile
Route::get('/dashboard/profile', [App\Http\Controllers\ProfileController::class, 'admin'])->name('profile-admin')->middleware(['role:admin|karyawan']);
Route::get('/dashboard/profile/edit', [App\Http\Controllers\ProfileController::class, 'editProfile'])->name('profile-admin.edit')->middleware(['role:admin|karyawan']);
Route::put('/dashboard/profile/update/{user_id}', [App\Http\Controllers\ProfileController::class, 'updateProfile'])->name('profile-admin.update')->middleware(['role:admin|karyawan']);

// settings
Route::get('/dashboard/settings', [App\Http\Controllers\SettingController::class, 'index'])->name('settings.index')->middleware(['role:admin']);
Route::put('/dashboard/settings/update', [App\Http\Controllers\SettingController::class, 'update'])->name('settings.update')->middleware(['role:admin']);

// Member Routes
Route::middleware(['auth'])->group(function () {
    Route::get('/member/dashboard', [App\Http\Controllers\MemberAreaController::class, 'dashboard'])->name('member.dashboard');
    Route::get('/member/loan/request/{book_id}', [App\Http\Controllers\MemberAreaController::class, 'requestLoan']);
    Route::post('/member/loan/store', [App\Http\Controllers\MemberAreaController::class, 'storeLoan'])->name('member.loan.store');
    Route::get('/member/history', [App\Http\Controllers\MemberAreaController::class, 'history'])->name('member.history');
    Route::get('/member/profile', [App\Http\Controllers\MemberAreaController::class, 'profile'])->name('member.profile');
    Route::post('/member/profile/update', [App\Http\Controllers\MemberAreaController::class, 'updateProfile'])->name('member.profile.update');
    Route::get('/member/read/{book_id}', [App\Http\Controllers\MemberAreaController::class, 'readBook'])->name('member.read');
    Route::get('/member/read/{book_id}', [App\Http\Controllers\MemberAreaController::class, 'readBook'])->name('member.read');
});

// Master Data Routes
Route::prefix('dashboard/master')->middleware(['role:admin'])->group(function () {
    Route::resource('prodi', App\Http\Controllers\ProdiController::class, ['as' => 'admin.master']);
    Route::resource('jurusan', App\Http\Controllers\JurusanController::class, ['as' => 'admin.master']);
    Route::resource('semester', App\Http\Controllers\SemesterController::class, ['as' => 'admin.master']);
});
