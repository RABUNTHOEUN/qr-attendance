<?php

use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\StudentController;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/scan', function () {
    return view('scan');
});
Route::get('/students', [StudentController::class, 'index'])->name('students.index');
Route::get('/attendance/form/{student_id}', [AttendanceController::class, 'showForm'])->name('attendance.form');
Route::post('/attendance/submit', [AttendanceController::class, 'submit'])->name('attendance.submit');
Route::get('/admin/attendances', [AttendanceController::class, 'index'])->name('admin.attendance');
Route::get('/check-student/{id}', function ($id) {
    $exists = Student::where('student_id', $id)->exists();
    return response()->json(['exists' => $exists]);
});
