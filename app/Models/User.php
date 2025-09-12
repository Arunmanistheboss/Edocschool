<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Notifications\CustomResetPasswordNotification;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // Relation 1:1 entre User et Student
    public function student(): HasOne
    {
        return $this->hasOne(Student::class, 'id');
    }

    // 🔁 Relation 1:1 vers Teacher
    public function teacher(): HasOne
    {
        return $this->hasOne(Teacher::class, 'id');
    }

    // 🔁 Relation 1:1 vers Admin
    public function admin()
    {
        return $this->hasOne(Admin::class, 'id');
    }


    //  Vérifie si l'utilisateur est un élève
    public function isStudent(): bool
    {
        return $this->student()->exists();
    }

    // Vérifie si l'utilisateur est un enseignant
    public function isTeacher(): bool
    {
        return $this->teacher()->exists();
    }

    //  Vérifie si l'utilisateur est un admin
    public function isAdmin(): bool
    {
        return $this->admin()->exists();
    }

    public function getRoleType(): string
    {
        if ($this->admin()->exists()) return 'admin';
        if ($this->teacher()->exists()) return 'teacher';
        if ($this->student()->exists()) return 'student';

        return 'unknown';
    }

    public function sendPasswordResetNotification($token)
{
    $this->notify(new CustomResetPasswordNotification($token));
}
}