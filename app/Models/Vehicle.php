<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    protected $fillable = [
        'brand','model','type','year','plate',
        'price_per_day','mileage','status','image','description'
    ];

    public function rentals()
    {
        return $this->hasMany(Rental::class);
    }

    /**
     * Retourne l'URL de l'image
     * Si c'est une URL Cloudinary (commence par http), on la renvoie
     * Sinon, on suppose que c'est un stockage local
     */
    public function getImageUrlAttribute(): ?string
{
    if (!$this->image) return null;

    // URL complète (Cloudinary ou URL externe)
    if (str_starts_with($this->image, 'http')) {
        return $this->image;
    }

    // Storage local
    return asset('storage/'.$this->image);
}

    /**
     * Retourne la prochaine date de disponibilité
     * Utile pour les véhicules loués
     */
    public function getNextAvailableDateAttribute(): ?string
    {
        if ($this->status === 'available') return null;

        $lastRental = $this->rentals()
            ->whereIn('status', ['confirmed','ongoing'])
            ->orderByDesc('end_date')
            ->first();

        return $lastRental
            ? $lastRental->end_date->format('d/m/Y')
            : null;
    }

    public function isAvailable(): bool
    {
        return $this->status === 'available';
    }
}