<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class File extends Model
{
     use HasFactory;

    protected $fillable = [
        'name',
        'type',
        'path',
        'date_upload',
        'folder_id',
        'teacher_id',
    ];

    protected $casts = [
        'date_upload' => 'datetime',
    ];



    /**
     * 🔁 L'utilisateur qui a uploadé le fichier
     * Cardinalité : n → 1
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * 🔁 Le dossier dans lequel est stocké le fichier
     * Cardinalité : n → 1
     */
    public function folder(): BelongsTo
    {
        return $this->belongsTo(Folder::class);
    }
}