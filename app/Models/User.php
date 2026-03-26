<?php
namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    protected $fillable = [
    'name',
    'email',
    'password',
    'phone',
    'address',
    'cin',
    'driving_license',
    'role',
    'is_active',
];
    protected $hidden = ['password', 'remember_token'];

    // Relations
    public function rentals()
    {
        return $this->hasMany(Rental::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }
    

    // Helpers rôles
    public function isAdmin(): bool { return $this->role === 'admin'; }
    public function isAgent(): bool { return $this->role === 'agent'; }
    public function isClient(): bool { return $this->role === 'client'; }
}