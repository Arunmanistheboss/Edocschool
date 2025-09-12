<?php

namespace Database\Seeders;

use App\Models\Folder;
use App\Models\Teacher;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FolderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $teachers = Teacher::all();

        foreach ($teachers as $teacher) {
            // Crée 2 dossiers racines
            $rootFolders = Folder::factory(2)->create([
                'teacher_id' => $teacher->id,
                'parent_id' => null,
            ]);

            foreach ($rootFolders as $root) {
                // Crée 2 sous-dossiers
                $subFolders = Folder::factory(2)->create([
                    'teacher_id' => $teacher->id,
                    'parent_id' => $root->id,
                ]);

                // Pour chaque sous-dossier, ajoute 1 sous-sous-dossier
                foreach ($subFolders as $sub) {
                    Folder::factory()->create([
                        'teacher_id' => $teacher->id,
                        'parent_id' => $sub->id,
                    ]);
                }
            }
        }
    }
}