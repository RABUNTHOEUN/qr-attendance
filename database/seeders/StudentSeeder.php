<?php

namespace Database\Seeders;

use App\Models\Student;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StudentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Student::create(['student_id' => 'ST001', 'name' => 'Student 1']);
        Student::create(['student_id' => 'ST002', 'name' => 'Student 2']);
        Student::create(['student_id' => 'ST003', 'name' => 'Student 3']);
        Student::create(['student_id' => 'ST004', 'name' => 'Student 4']);
        Student::create(['student_id' => 'ST005', 'name' => 'Student 5']);
        Student::create(['student_id' => 'ST006', 'name' => 'Student 6']);
        Student::create(['student_id' => 'ST007', 'name' => 'Student 7']);
        Student::create(['student_id' => 'ST008', 'name' => 'Student 8']);
    }
}
