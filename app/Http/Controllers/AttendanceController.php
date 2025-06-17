<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Student;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    public function showForm($student_id)
    {
        $student = Student::where('student_id', $student_id)->firstOrFail();
        return view('attendance.form', compact('student'));
    }

    public function submit(Request $request)
    {
        $student = Student::where('student_id', $request->student_id)->first();

        Attendance::create([
            'student_id' => $student->id
        ]);

        return redirect()->back()->with('success', 'ចុះវត្តមានរួចរាល់!');
    }

    public function index()
    {
        $attendances = Attendance::with('student')->latest()->paginate(20);
        return view('admin.attendance', compact('attendances'));
    }
}
