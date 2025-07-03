<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Folder;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class FolderController extends Controller
{
    /**
     * Affiche la liste des dossiers visibles pour l’élève connecté.
     */
    public function index(Request $request): View
    {
        $student = auth()->user()->student;
        $classId = $student->schoolClass?->id;

        $parentId = $request->get('parent_id');

        if ($classId) {
            // Récupérer tous les dossiers visibles par la classe
            $folders = Folder::whereHas('visibleToClasses', function ($query) use ($classId) {
                $query->where('school_class_id', $classId);
            })
                ->where('parent_id', $parentId)
                ->get();

            $currentFolder = $parentId
                ? Folder::with('parentRecursive', 'files')->findOrFail($parentId)
                : null;
        } else {
            $folders = collect();
            $currentFolder = null;
        }

        return view('student.folders.index', compact('folders', 'currentFolder'));
    }
}