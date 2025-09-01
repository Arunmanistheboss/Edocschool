<?php

namespace Database\Factories;

use App\Models\Teacher;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Folder>
 */
class FolderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $teacher = \App\Models\Teacher::inRandomOrder()->first();
        return [
           'teacher_id' => $teacher->id,
            'name' => fake()->sentence(3),
            'date_upload' => now(),
            'parent_id' => null,
        ];
    }
}