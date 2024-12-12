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

/* Login routes*/ 

Route::get('','\App\Http\Controllers\LoginController@showLoginForm')->name('login');
Route::post('', '\App\Http\Controllers\LoginController@store')->name('login.store');


/* Registration routes*/ 

Route::get('/registration', [App\Http\Controllers\RegistrationController::class, 'index'])->name('registration.index');
Route::post('/register', [App\Http\Controllers\RegistrationController::class, 'store'])->name('register.store');

/* Dashboard routes*/
Route::get('/dashboard', [App\Http\Controllers\DashboardController::class, 'showDashboard'])->name('dashboard');


/* Logout route*/

Route::post('/logout', function () {
    auth()->logout();
    return redirect('');
})->name('logout');

// profile  routes

Route::get('/profile', [App\Http\Controllers\ProfileController::class, 'showProfile'])->name('profile');
Route::post('/profile/update', [App\Http\Controllers\ProfileController::class, 'updateProfile'])->name('profile.update');

//Staff routes
Route::get('/staff/teachers', [App\Http\Controllers\StaffController::class, 'getTeachers']);
Route::post('/staff/onboard-teacher', [App\Http\Controllers\StaffController::class, 'onboardTeacher']);
Route::post('/staff/update-teacher', [App\Http\Controllers\StaffController::class, 'updateTeacher']);

//courses routes
Route::get('/fetch-courses', [App\Http\Controllers\CoursesController::class, 'getCourses']);
Route::post('/courses/{id}/assign-teachers', [App\Http\Controllers\CoursesController::class, 'assignTeachers']);
Route::get('/fetch-teachers', [App\Http\Controllers\CoursesController::class, 'fetchTeachers']);
Route::post('/add-course', [App\Http\Controllers\CoursesController::class, 'addCourse']);
Route::get('/fetch-teacher-courses', [App\Http\Controllers\TeacherCoursesController::class, 'getAssignedCourses']);
Route::get('/fetch-semester-dropdown', [App\Http\Controllers\StudentCoursesController::class, 'getSemesterDropdown']);
// Route::get('/fetch-courses-by-semester', [App\Http\Controllers\StudentCoursesController::class, 'getCoursesBySemester']);
Route::post('/fetch-courses', [App\Http\Controllers\StudentCoursesController::class, 'getCoursesBySemester']);
Route::post('/register-course', [App\Http\Controllers\StudentCoursesController::class, 'registerForCourse']);
Route::get('/fetch-registered-courses', [App\Http\Controllers\StudentCoursesController::class, 'getRegisteredCourses']);









