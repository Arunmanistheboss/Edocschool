<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\SchoolClass\StoreSchoolClassRequest;
use App\Http\Requests\Admin\SchoolClass\UpdateSchoolClassRequest;
use App\Models\SchoolClass;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SchoolClassContoller extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        // On récupère toutes les classes de l'école
        $school_classes = SchoolClass::all();

        // On retourne la vue avec les données
        return view('admin.school_classes.index', compact('school_classes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('admin.school_classes.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSchoolClassRequest $request): RedirectResponse
    {
        SchoolClass::create([
            'name' => $request->name,
        ]);

         return redirect()->route('admin.school_classes.index')->with('success', 'Classe ajoutée avec succès.');
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
    public function edit(SchoolClass $school_class): View
    {
        return view('admin.school_classes.edit', compact('school_class'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSchoolClassRequest $request, SchoolClass $school_class): RedirectResponse
    {
        $school_class->update([
            'name' => $request->name,
        ]);

        return redirect()->route('admin.school_classes.index')->with('success', 'Classe mise à jour avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SchoolClass $school_class): RedirectResponse
    {
        $school_class->delete();

        return redirect()->route('admin.school_classes.index')->with('success', 'Classe supprimée avec succès.');
    }
}
