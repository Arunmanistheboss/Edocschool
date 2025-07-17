<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Student\StoreStudentRequest;
use App\Http\Requests\Admin\Student\UpdateStudentRequest;
use App\Models\SchoolClass;
use App\Models\Student;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        // Charge les élèves avec leurs relations user et schoolClass
        $students = Student::paginate(10);

        // Renvoie la vue avec les données
        return view('admin.students.index', compact('students'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $classes = SchoolClass::all(); // Pour peupler la liste déroulante
        return view('admin.students.create', compact('classes'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreStudentRequest $request): RedirectResponse
    {
        // 1. Créer l'utilisateur lié à l'élève
        $user = User::create([
            'first_name' => $request->input('first_name'), // Prénom
            'last_name' => $request->input('last_name'),   // Nom
            'email' => $request->input('email'),           // Email
            'password' => Hash::make($request->input('password')), // Mot de passe hashé
            'email_verified_at' => now(),                  // On considère le mail comme vérifié
        ]);

        // 2. Créer l'élève et l'associer à une classe (si fournie)
        Student::create([
            'user_id' => $user->id,                         // Lien avec l'utilisateur
            'school_class_id' => $request->input('school_class_id') // Optionnel : classe associée
        ]);

        // 3. Redirection avec message de succès
        return redirect()->route('admin.students.index')->with('success', 'Élève ajouté avec succès.');
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
    public function edit(Student $student): View
    {
        $student->load('user'); // On charge les infos de l'utilisateur lié

        $classes = SchoolClass::all(); // On récupère toutes les classes pour la liste déroulante

        return view('admin.students.edit', compact('student', 'classes'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateStudentRequest $request, Student $student): RedirectResponse
    {
        // On charge la relation "user" pour accéder à ses champs
        $student->load('user');

        $user = $student->user;

        // Mise à jour des données utilisateur
        $user->first_name = $request->input('first_name');
        $user->last_name = $request->input('last_name');
        $user->email = $request->input('email');

        // Si le mot de passe est rempli, on le met à jour
        if ($request->filled('password')) {
            $user->password = Hash::make($request->input('password'));
        }

        $user->save();

        // Mise à jour de la classe de l'élève
        $student->school_class_id = $request->input('school_class_id');
        $student->save();

        return redirect()->route('admin.students.index')->with('success', 'Élève mis à jour avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Student $student): RedirectResponse
    {
        // Charge la relation "user" pour pouvoir supprimer aussi l'utilisateur
        $student->load('user');

        // Supprime d'abord l'utilisateur, ce qui supprimera automatiquement l'élève
        $student->user->delete();

        return redirect()->route('admin.students.index')->with('success', 'Élève supprimé avec succès.');
    }
}
