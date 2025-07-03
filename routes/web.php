<?php
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Teacher\DashboardController as TeacherDashboardController;
use App\Http\Controllers\Admin\SchoolClassContoller;
use App\Http\Controllers\Admin\StudentController as StudentController;
use App\Http\Controllers\Admin\TeacherController as TeacherController;
use App\Http\Controllers\teacher\FileController;
use App\Http\Controllers\Teacher\FolderController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    if (auth()->check()) {
        $user = auth()->user();

        if ($user->admin()->exists()) {
            return redirect()->route('admin.dashboard');
        }
        if ($user->teacher()->exists()) {
            return redirect()->route('teacher.dashboard');
        }


    }

    return view('welcome');
});



Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', 'role_type:admin'])->group(function () {
    Route::get('/admin/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');

    Route::prefix('admin')->name('admin.')->group(function () {
        Route::resource('teachers', TeacherController::class);
        Route::resource('students', StudentController::class);
        Route::resource('school_classes', SchoolClassContoller::class);
    });
    
});

Route::middleware(['auth', 'role_type:teacher'])->group(function () {
    Route::get('/teacher/dashboard', [TeacherDashboardController::class, 'index'])->name('teacher.dashboard');

    // Ajouter ici ci-dessous
     Route::prefix('teacher')->name('teacher.')->group(function () {
        Route::resource('folders', FolderController::class);
    });

     // Ajouter ici ci-dessous
    Route::post('/teacher/folders/{folder}/files', [FileController::class, 'store'])
        ->name('teacher.files.store');
    // Ajouter ici ci-dessous
    Route::delete('/teacher/files/{file}', [FileController::class, 'destroy'])
        ->name('teacher.files.destroy');
});



require __DIR__.'/auth.php';
