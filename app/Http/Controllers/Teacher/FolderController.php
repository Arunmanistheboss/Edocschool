<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Http\Requests\Teacher\StoreFolderRequest;
use App\Http\Requests\Teacher\UpdateFolderRequest;
use App\Models\Folder;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class FolderController extends Controller
{
    use AuthorizesRequests;

    /**
     * Affiche la liste des dossiers (racine ou sous-dossiers).
     */
    public function index(?string $folder = null): View
    {
        $parentId = $folder;

        $currentFolder = null;

        if ($parentId) {
            $currentFolder = Folder::with('parentRecursive')->findOrFail($parentId);

            $this->authorize('view', $currentFolder);

            $folders = Folder::where('parent_id', $parentId)
                ->where('teacher_id', auth()->id())
                ->withCount('children')
                ->get();
        } else {
            $folders = Folder::whereNull('parent_id')
                ->where('teacher_id', auth()->id())
                ->withCount('children')
                ->get();
        }

        return view('teacher.folders.index', compact('folders', 'currentFolder'));
    }


    /**
     * Affiche le formulaire de création d’un dossier.
     *
     * Exemple d’URL :
     *   /teacher/folders/create
     *   /teacher/folders/create/70
     */
    public function create(?string $parent = null): View
    {
        $this->authorize('create', Folder::class);

        $teacher = auth()->user()->teacher;
        $classes = $teacher->schoolClasses;

        $parentId = $parent;

        return view('teacher.folders.create', compact('classes', 'parentId'));
    }


    /**
     * Enregistre un nouveau dossier.
     */
    public function store(StoreFolderRequest $request): RedirectResponse
    {
        $this->authorize('create', Folder::class);

        $parentId = $request->input('parent_id');

        $folder = Folder::create([
            'name'      => $request->name,
            'teacher_id'   => auth()->id(),
            'parent_id' => $parentId,
        ]);

        $folder->visibleToClasses()->sync(
            $request->input('school_class_ids', [])
        );

        return redirect()
            ->route('teacher.folders.index', $parentId)
            ->with('success', 'Dossier créé avec succès.');
    }


    /**
     * Affiche le formulaire de modification d’un dossier.
     */
    public function edit(string $folder): View
    {
        $folderModel = Folder::findOrFail($folder);
        $this->authorize('update', $folderModel);

        $teacher = auth()->user()->teacher;
        $classes = $teacher->schoolClasses;

        $selected = $folderModel->visibleToClasses
            ->pluck('id')
            ->toArray();

        return view('teacher.folders.edit', [
            'folder'   => $folderModel,
            'classes'  => $classes,
            'selected' => $selected,
        ]);
    }


    /**
     * Met à jour un dossier existant.
     */
    public function update(UpdateFolderRequest $request, string $folder): RedirectResponse
    {
        $folderModel = Folder::findOrFail($folder);
        $this->authorize('update', $folderModel);

        $parentId = $request->input('parent_id');

        $folderModel->update([
            'name'      => $request->name,
            'parent_id' => $parentId,
        ]);

        $folderModel->visibleToClasses()->sync(
            $request->input('school_class_ids', [])
        );

        return redirect()
            ->route('teacher.folders.index', $parentId)
            ->with('success', 'Dossier mis à jour avec succès.');
    }


    /**
     * Supprime un dossier existant.
     */
    public function destroy(string $folder): RedirectResponse
    {
        $folderModel = Folder::findOrFail($folder);
        $this->authorize('delete', $folderModel);

        $parentId = $folderModel->parent_id;

        $folderModel->delete();

        return redirect()
            ->route('teacher.folders.index', $parentId)
            ->with('success', 'Dossier supprimé.');
    }
}
