<?php

namespace Database\Factories;

use App\Models\Folder;
use App\Models\User;
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

    $folder = \App\Models\Folder::inRandomOrder()->first();

    return [
        'name' => fake()->words(3, true),
        'type' => $type,
        'path' => 'files/' . $fileName, // 👈 correspond au type
        'teacher_id' => $folder ? $folder->teacher_id : \App\Models\Teacher::inRandomOrder()->first()->id,
        'folder_id' => $folder?->id,
        'date_upload' => now(),
    ];
    }
}