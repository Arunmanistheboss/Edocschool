<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ClassTeacher extends Model
{
   use HasFactory;

    public $incrementing = false; // Pas de clé auto-incrémentée
    public $timestamps = false;   // Pas de created_at/updated_at

    protected $fillable = [
        'teacher_id',
        'school_class_id',
    ];

    /**
     * 🔁 Professeur associé
     */
    public function teacher(): BelongsTo
    {
        return $this->belongsTo(Teacher::class);
    }

    /**
     * 🔁 Classe associée
     */
    public function schoolClass(): BelongsTo
    {
        return $this->belongsTo(SchoolClass::class);
    }
}