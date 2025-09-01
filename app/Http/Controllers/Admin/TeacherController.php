<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Teacher\StoreTeacherRequest;
use App\Http\Requests\Admin\Teacher\UpdateTeacherRequest;
use App\Models\SchoolClass;
use App\Models\Teacher;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class TeacherController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        // Récupère tous les enseignants avec leurs infos utilisateur
        $teachers = Teacher::with('user')->get();

        // Affiche la vue avec les données
        return view('admin.teachers.index', compact('teachers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        // → On récupère toutes les classes existantes
        // pour les afficher sous forme de cases à cocher
        $classes = SchoolClass::all();

        // → On envoie les classes à la vue
        return view('admin.teachers.create', compact('classes'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTeacherRequest $request): RedirectResponse
    {
        // Création du user lié au prof
        $user = User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'email_verified_at' => now(),
        ]);

        // Lie le user à un teacher
        $teacher = Teacher::create([
            'id' => $user->id,
        ]);

        // on attache les classes cochées dans le formulaire
        $teacher->schoolClasses()->sync($request->input('school_class_ids', []));


        return redirect()->route('admin.teachers.index')->with('success', 'Enseignant ajouté avec succès.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
   public function edit(Teacher $teacher): View
    {
        // Charge l'utilisateur lié + les classes liées au professeur
        $teacher->load('user', 'schoolClasses');

        // Récupère toutes les classes (pour afficher les cases à cocher)
        $classes = SchoolClass::all();

        // Récupère les classes déjà associées au prof pour pré-cocher les cases
        $selected = $teacher->schoolClasses->pluck('id')->toArray();

        return view('admin.teachers.edit', compact('teacher', 'classes', 'selected'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTeacherRequest $request, Teacher $teacher): RedirectResponse
    {
        $teacher->load('user');
        $user = $teacher->user;

        $user->first_name = $request->input('first_name');
        $user->last_name = $request->input('last_name');
        $user->email = $request->input('email');

        if ($request->filled('password')) {
            $user->password = bcrypt($request->input('password'));
        }

        $user->save();

        // Synchroniser les classes sélectionnées avec la table pivot
        $teacher->schoolClasses()->sync($request->input('school_class_ids', []));

        return redirect()->route('admin.teachers.index')->with('success', 'Enseignant mis à jour avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Teacher $teacher): RedirectResponse
    {
        $teacher->load('user');

        // On supprime d'abord l'utilisateur (ce qui supprimera aussi le teacher s'il y a une cascade)
        $teacher->user->delete();

        return redirect()->route('admin.teachers.index')->with('success', 'Enseignant supprimé avec succès.');
    }
}
