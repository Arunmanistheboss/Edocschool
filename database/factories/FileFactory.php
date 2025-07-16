<?php

namespace Database\Factories;

use App\Models\Folder;
use App\Models\Teacher;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\File>
 */
class FileFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $type = fake()->randomElement(['pdf', 'docx', 'txt']);
        $fileName = fake()->slug() . '.' . $type;

        $folder = Folder::inRandomOrder()->first();
        if (!$folder) {
            $teacher = Teacher::factory()->create();
            $folder = Folder::factory()->create(['teacher_id' => $teacher->id]);
        }

        return [
            'name' => fake()->words(3, true),
            'type' => $type,
            'path' => 'files/' . $fileName, // 👈 correspond au type
            'teacher_id' => $folder->teacher_id,
            'folder_id' => $folder?->id,
            'date_upload' => now(),
        ];
    }
}
