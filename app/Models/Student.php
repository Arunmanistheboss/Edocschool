<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Student extends Model
{
    use HasFactory;

    // Autorise l’attribution en masse de ces champs
    protected $fillable = [
        'school_class_id',
        'user_id',
    ];

    /**
        * Chaque élève est lié à un utilisateur 
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
        * Chaque élève peut appartenir à une classe
     */
    public function schoolClass(): BelongsTo
    {
        return $this->belongsTo(SchoolClass::class);
    }
}