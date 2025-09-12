<?php

namespace Database\Factories;

use App\Models\Folder;
use App\Models\SchoolClass;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\FolderVisibility>
 */
class FolderVisibilityFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'folder_id' => Folder::inRandomOrder()->first()->id,
            'school_class_id' => SchoolClass::inRandomOrder()->first()->id,
        ];
    }
}