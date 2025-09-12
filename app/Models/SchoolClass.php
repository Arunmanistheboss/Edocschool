<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SchoolClass extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
    ];

    /**
     * Une classe contient plusieurs élèves
     */
    public function students(): HasMany
    {
        return $this->hasMany(Student::class);
    }

    /**
     * Une classe est enseignée par plusieurs enseignants (many-to-many)
     */
    public function teachers(): BelongsToMany
    {
        return $this->belongsToMany(Teacher::class, 'class_teachers');
    }

    public function visibleFolders(): BelongsToMany
    {
    return $this->belongsToMany(Folder::class, 'folder_visibilities');
    }

}