<?php

namespace App\Http\Controllers\teacher;

use App\Http\Controllers\Controller;
use App\Http\Requests\Teacher\StoreFileRequest;
use App\Models\File;
use App\Models\Folder;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FileController extends Controller
{
    use AuthorizesRequests;

    /**
     * Enregistre un fichier uploadé dans un dossier précis.
     */
    public function store(StoreFileRequest $request, Folder $folder): RedirectResponse
    {
        // Autorisation : seul un prof peut uploader un fichier dans SES dossiers
        $this->authorize('update', $folder);

        // Upload physique sur le disque local (storage/app/public/uploads)
        $originalName = $request->file('file')->getClientOriginalName();
        $path = $request->file('file')->storeAs(
            'uploads',
            uniqid() . '_' . $originalName,
            'public'
        );

        $originalName = $request->file('file')->getClientOriginalName();
        $nameOnly = pathinfo($originalName, PATHINFO_FILENAME);
        $ext = pathinfo($originalName, PATHINFO_EXTENSION);

        $newName = $originalName;
        $counter = 1;

        while ($folder->files()->where('name', $newName)->exists()) {
            $newName = $nameOnly . "(" . $counter . ')' . '.' . $ext;
            $counter++;
        }



        // Création de l'enregistrement en BDD
        File::create([
            'name' => $newName,
            'type' => $request->file('file')->getClientMimeType(),
            'path' => $path,
            'date_upload' => now(),
            'folder_id' => $folder->id,
            'teacher_id' => auth()->id(),
        ]);

        return redirect()
            ->route('teacher.folders.index', $folder)
            ->with('success', 'Fichier uploadé avec succès.');
    }

    /**
     * Supprime un fichier déjà présent.
     */
    public function destroy(File $file): RedirectResponse
    {
        $this->authorize('delete', $file->folder);
        // Vérifie que l'utilisateur peut supprimer dans ce dossier

        // Supprime physiquement le fichier du disque
        Storage::disk('public')->delete($file->path);

        $file->delete();

        return back()->with('success', 'Fichier supprimé.');
    }
}