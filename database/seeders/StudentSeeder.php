<?php

namespace Database\Seeders;

use App\Models\SchoolClass;
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
         if (SchoolClass::count() === 0) {
            $this->command->error('Aucune classe trouvée. Lance SchoolClassSeeder d’abord.');
            return;
        }

        // Crée 20 élèves avec un user lié et une classe au hasard
        Student::factory(20)->create();
    }
}