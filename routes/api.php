<?php

use App\Models\Student;
use Illuminate\Support\Facades\Route;

Route::get('/check-student/{id}', function ($id) {
    $exists = Student::where('student_id', $id)->exists();
    return response()->json(['exists' => $exists]);
});
