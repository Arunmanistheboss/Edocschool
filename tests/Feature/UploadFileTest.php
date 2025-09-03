<?php

use App\Models\User;
use App\Models\Teacher;
use App\Models\Folder;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('permet à un enseignant de téléverser un fichier dans son propre dossier', function () {
    // Simule le disque "public" (pas d’écriture réelle)
    Storage::fake('public');

    // Crée un user + teacher
    $user = User::factory()->create();
    Teacher::create(['id' => $user->id]);
    $this->actingAs($user);

    // Crée un dossier pour ce teacher
    $folder = Folder::factory()->create([
        'teacher_id' => $user->id,
    ]);

    // Fichier simulé (nom : cours-maths.pdf)
    $fichier = UploadedFile::fake()->create('cours-maths.pdf', 100, 'application/pdf');

    // Requête POST vers le contrôleur d’upload
    $response = $this->post(route('teacher.files.store', $folder), [
        'file' => $fichier,
    ]);

    // Redirection attendue
    $response->assertRedirect();

    // 🔍 Partie dynamique — vérifie que le fichier a bien été stocké avec un nom unique
    $originalName = $fichier->getClientOriginalName();

    $generatedPath = collect(Storage::disk('public')->files('uploads'))
        ->first(fn ($path) => str_ends_with($path, $originalName));

    expect($generatedPath)->not->toBeNull();
    Storage::disk('public')->assertExists($generatedPath);

    // 🔎 Vérifie que le fichier est bien enregistré en base de données
    $this->assertDatabaseHas('files', [
        'name' => 'cours-maths.pdf',
        'folder_id' => $folder->id,
        'teacher_id' => $user->id,
        'type' => 'application/pdf',
    ]);
});
