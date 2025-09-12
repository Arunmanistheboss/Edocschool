<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Folder;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;

class FolderController extends Controller
{
    use AuthorizesRequests;
    /**
     * Affiche la liste des dossiers visibles pour l’élève connecté.
     */
    public function index(?string $folder = null): View
    {
        $student = auth()->user()->student;
        $classId = $student->schoolClass?->id;

        $parentId = $folder;

        $currentFolder = null;

        if ($parentId) {
            $currentFolder = Folder::findOrFail($parentId);

            $this->authorize('view', $currentFolder);

            $currentFolder->load(['parentRecursive', 'files']);
        }

        if ($classId) {
            $folders = Folder::whereHas('visibleToClasses', function ($query) use ($classId) {
                $query->where('school_class_id', $classId);
            })
                ->where('parent_id', $parentId)
                ->get();
        } else {
            $folders = collect();
        }

        return view('student.folders.index', compact('folders', 'currentFolder'));
    }
}