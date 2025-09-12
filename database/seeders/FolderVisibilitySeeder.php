<?php

namespace Database\Seeders;

use App\Models\Folder;
use App\Models\FolderVisibility;
use App\Models\SchoolClass;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FolderVisibilitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $folders = Folder::all();
        $classes = SchoolClass::all();

        foreach ($folders as $folder) {
            // Donner entre 1 et 3 classes qui peuvent voir ce dossier
            $visibleTo = $classes->random(rand(1, 3));
            foreach ($visibleTo as $class) {
                FolderVisibility::firstOrCreate([
                    'folder_id' => $folder->id,
                    'school_class_id' => $class->id,
                ]);
            }
        }
    }
}