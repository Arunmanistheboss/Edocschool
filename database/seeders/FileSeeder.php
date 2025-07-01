<?php

namespace Database\Seeders;

use App\Models\File;
use App\Models\Folder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FileSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         $folders = Folder::all();

        foreach ($folders as $folder) {
            File::factory(rand(2, 5))->create([
                'folder_id' => $folder->id,
                'user_id' => $folder->user_id,
            ]);
        }
    }
}