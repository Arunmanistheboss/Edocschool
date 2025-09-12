<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Admin extends Model
{

    use HasFactory;

     // On précise que la clé primaire s'appelle id, n'est pas auto-incrémentée et est de type int
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'int';

    protected $fillable = ['id'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id');
    }
}