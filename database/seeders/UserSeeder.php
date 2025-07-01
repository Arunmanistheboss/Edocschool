<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        
          $admin = User::factory()->create([
            'first_name' => 'Admin',
            'last_name' => 'Principal',
            'email' => 'admin@edocshool.local',
            'password' => bcrypt('passworda'),
        ]);
         Admin::create(['user_id' => $admin->id]);

        
          $teacher = User::factory()->create([
            'first_name' => 'Teacher',
            'last_name' => 'Principal',
            'email' => 'teacher@edocshool.local',
            'password' => bcrypt('passwordt'),
        ]);
        Teacher::create(['user_id' => $teacher->id]);

        
        $student = User::factory()->create([
            'first_name' => 'Student',
            'last_name' => 'Principal',
            'email' => 'Student@edocshool.local',
            'password' => bcrypt('passwords'),
        ]);
        Student::create(['user_id' => $student->id]);

   
        User::factory(5)->create();
    }
}