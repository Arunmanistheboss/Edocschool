<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FolderVisibility extends Model
{
   use HasFactory;

    public $incrementing = false; // ← Pas d'id auto-incrémenté
    public $timestamps = false;   // ← Table pivot pure

    protected $fillable = [
        'school_class_id',
        'folder_id',
    ];

    /**
     * 🔁 Dossier visible
     */
    public function folder(): BelongsTo
    {
        return $this->belongsTo(Folder::class);
    }

    /**
     * 🔁 Classe ayant accès au dossier
     */
    public function schoolClass(): BelongsTo
    {
        return $this->belongsTo(SchoolClass::class);
    }
}