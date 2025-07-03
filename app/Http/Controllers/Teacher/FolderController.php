<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Http\Requests\Teacher\StoreFolderRequest;
use App\Http\Requests\Teacher\UpdateFolderRequest;
use App\Models\Folder;
use App\Models\SchoolClass;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class FolderController extends Controller
{
    use AuthorizesRequests; // Permet d’utiliser les méthodes comme $this->authorize() pour vérifier les droits
    /**
     * Affiche la liste des dossiers (racine ou sous-dossiers).
     */
    public function index(Request $request): View
    {
        // Récupère le professeur connecté via auth() → user() → teacher()
        $teacher = auth()->user()->teacher;

        // Cherche l'ID du dossier parent si on navigue dans un sous-dossier, sinon NULL
        $parentId = $request->get('parent_id');

        // Récupère les dossiers du prof, ayant ce parent_id (null = dossiers racine)
        $folders = Folder::where('user_id', auth()->id())
            ->where('parent_id', $parentId)
            ->withCount('children') // ajoute un champ children_count pour savoir combien il y a de sous-dossiers
            ->get();

        // Si on est dans un sous-dossier, récupère le dossier courant et ses parents (breadcrumb)
        $currentFolder = $parentId ? Folder::with('parentRecursive')->findOrFail($parentId) : null;

        // Retourne la vue index.blade.php avec les variables $folders et $currentFolder
        return view('teacher.folders.index', compact('folders', 'currentFolder'));
    }

    /**
     * Affiche le formulaire de création de dossier.
     */
   public function create(): View
    {
        $this->authorize('create', Folder::class);
        // Vérifie que l’utilisateur a le droit de créer un dossier (Policy)

        // Récupère uniquement les classes liées au prof connecté
        $teacher = auth()->user()->teacher;
        $classes = $teacher->schoolClasses;

        return view('teacher.folders.create', compact('classes'));
    }

    /**
     * Enregistre un nouveau dossier en base.
     */
    public function store(StoreFolderRequest $request): RedirectResponse
    {
        $this->authorize('create', Folder::class);
        // Vérifie les droits via la Policy

        // Crée le dossier dans la base de données
        $folder = Folder::create([
            'name' => $request->name, // Nom du dossier
            'user_id' => auth()->id(), // L'utilisateur connecté (le prof)
            'parent_id' => $request->input('parent_id'), // Id du dossier parent (null si racine)
        ]);

        // Synchronise la table pivot folder_visibilities
        $folder->visibleToClasses()->sync(
            $request->input('school_class_ids', [])
        );

        // Redirige vers la liste des dossiers avec un message de succès
        return redirect()->route('teacher.folders.index')
            ->with('success', 'Dossier créé avec succès.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Affiche le formulaire d’édition d’un dossier existant.
     */
    public function edit(Folder $folder): View
    {
        $this->authorize('update', $folder);
        // Vérifie si le prof a le droit de modifier ce dossier

        // Récupère uniquement les classes liées au prof connecté
        $teacher = auth()->user()->teacher;
        $classes = $teacher->schoolClasses;

        $selected = $folder->visibleToClasses
            ->pluck('id')
            ->toArray();
        // Récupère la liste des classes déjà liées au dossier (pour les cases cochées)

        return view('teacher.folders.edit', compact(
            'folder',
            'classes',
            'selected'
        ));
    }

    /**
     * Enregistre la modification d’un dossier existant.
     */
    public function update(UpdateFolderRequest $request, Folder $folder): RedirectResponse
    {
        $this->authorize('update', $folder);
        // Vérifie les droits de modification via la Policy

        // Met à jour uniquement le nom du dossier
        $folder->update([
            'name' => $request->name
        ]);

        // Met à jour la table pivot des classes liées
        $folder->visibleToClasses()->sync(
            $request->input('school_class_ids', [])
        );

        return redirect()->route('teacher.folders.index')
            ->with('success', 'Dossier mis à jour avec succès.');
    }

    /**
     * Supprime un dossier existant.
     */
    public function destroy(Folder $folder): RedirectResponse
    {
        $this->authorize('delete', $folder);
        // Vérifie si le prof a le droit de supprimer ce dossier

        $folder->delete();
        // Supprime le dossier (ce qui supprime aussi ses sous-dossiers et fichiers via le booted du modèle)

        return redirect()->route('teacher.folders.index')
            ->with('success', 'Dossier supprimé.');
    }
}
