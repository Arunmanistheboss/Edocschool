<?php

namespace Database\Seeders;

use App\Models\ClassTeacher;
use App\Models\SchoolClass;
use App\Models\Teacher;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ClassTeacherSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $teachers = Teacher::all();
        $classes = SchoolClass::all();

        foreach ($teachers as $teacher) {
            // Chaque enseignant est assigné à 2 classes aléatoires
            $teacherClasses = $classes->random(2);

            foreach ($teacherClasses as $class) {
                ClassTeacher::create([
                    'teacher_id' => $teacher->id,
                    'school_class_id' => $class->id,
                ]);
            }
        }
    }
}