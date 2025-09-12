<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Folder extends Model
{
    use HasFactory;


    protected $fillable = ['name', 'teacher_id', 'parent_id', 'date_upload'];


    protected $casts = [
        'date_upload' => 'datetime',
    ];


    public function teacher(): BelongsTo
    {
        return $this->belongsTo(Teacher::class);
    }


    public function parent(): BelongsTo
    {
        return $this->belongsTo(Folder::class, 'parent_id');
    }


    public function children(): HasMany
    {
        return $this->hasMany(Folder::class, 'parent_id');
    }


    public function parentRecursive()
    {
        return $this->belongsTo(Folder::class, 'parent_id')->with('parentRecursive');
    }


    public function visibleToClasses(): BelongsToMany
    {
        return $this->belongsToMany(SchoolClass::class, 'folder_visibilities');
    }


    public function files(): HasMany
    {
        return $this->hasMany(File::class);
    }


    protected static function booted(): void
    {
        static::deleting(function (Folder $folder) {
            $folder->files()->delete(); // suppression des fichiers
            $folder->children()->each(fn($child) => $child->delete()); // suppression récursive des enfants
        });
    }
}
