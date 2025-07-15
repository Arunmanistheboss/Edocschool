<?php

namespace App\Policies;

use App\Models\Folder;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class FolderPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return false;
    }

    /**
     * Vérifie si le professeur peut voir ce dossier.
     * Seul le prof qui a créé le dossier peut le voir.
     */
    public function view(User $user, Folder $folder): bool
    {
       if ($user->isTeacher()) {
            return $folder->user_id === $user->id;
        }

        if ($user->isStudent()) {
            $student = $user->student;

            if (!$student || !$student->schoolClass) {
                return false;
            }

            return $folder->visibleToClasses()
                ->where('school_class_id', $student->schoolClass->id)
                ->exists();
        }

        return false;
       
    }

    /**
     * Vérifie si le professeur peut créer un dossier.
     * Tous les professeurs ont le droit de créer des dossiers.
     */
    public function create(User $user): bool
    {
        return $user->isTeacher();
    }

    /**
     * Vérifie si le professeur peut modifier ce dossier.
     * Uniquement si le dossier lui appartient.
     */
    public function update(User $user, Folder $folder): bool
    {
        return $this->view($user, $folder);
    }

    /**
     * Vérifie si le professeur peut supprimer ce dossier.
     * Uniquement si c’est lui qui l’a créé.
     */
    public function delete(User $user, Folder $folder): bool
    {
        return $this->view($user, $folder);
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Folder $folder): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Folder $folder): bool
    {
        return false;
    }
}