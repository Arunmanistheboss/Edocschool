<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Teacher extends Model
{
    use HasFactory;

    // On précise que la clé primaire s'appelle id, n'est pas auto-incrémentée et est de type int
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'int';

    protected $fillable = [
        'id',
    ];

    /**
     * Chaque enseignant EST un utilisateur (relation 1-1)
     * L'id est utilisé comme clé étrangère
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id');
    }

    /**
     * L'enseignant enseigne dans plusieurs classes (relation many-to-many)
     */
    public function schoolClasses(): BelongsToMany
    {
        return $this->belongsToMany(SchoolClass::class, 'class_teachers');
    }
}
