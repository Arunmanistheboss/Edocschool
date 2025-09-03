<?php

use App\Models\User;
use App\Models\Teacher;
use App\Models\SchoolClass;
use Illuminate\Foundation\Testing\RefreshDatabase;



it('permets à un enseignant connecté de créer un dossier visible pour certaines classes', function () {
    // Création d’un user et d’un teacher associé
    $user = User::factory()->create();
    Teacher::create(['id' => $user->id]);
    $this->actingAs($user);

    // Création de classes
    $classes = SchoolClass::factory()->count(2)->create(); // 4A, 5A

    // Requête POST simulée
    $response = $this->post(route('teacher.folders.store'), [
        'name' => 'Mon dossier de test',
        'parent_id' => null,
        'school_class_ids' => $classes->pluck('id')->toArray(), // ID des classes cochées
    ]);

    // Vérifie la redirection
    $response->assertRedirect();

    // Vérifie que le dossier est créé
    $this->assertDatabaseHas('folders', [
        'name' => 'Mon dossier de test',
        'teacher_id' => $user->id,
        'parent_id' => null,
    ]);

    // Vérifie la visibilité pour chaque classe
    $folder = \App\Models\Folder::where('name', 'Mon dossier de test')->first();

    foreach ($classes as $class) {
        $this->assertDatabaseHas('folder_visibilities', [
            'folder_id' => $folder->id,
            'school_class_id' => $class->id,
        ]);
    }


    // dump(\App\Models\Folder::all()->toArray());
    // dump(\App\Models\FolderVisibility::all()->toArray());
    // dump(\App\Models\SchoolClass::all()->toArray());
});
