<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    protected $fillable = [
        'brand','model','type','year','plate',
        'price_per_day','mileage','status','image','description'
    ];

    protected $appends = ['image_url', 'next_available_date'];

    public function rentals()
    {
        return $this->hasMany(Rental::class);
    }

    public function getImageUrlAttribute(): ?string
    {
        if (!$this->image) return null;
        if (str_starts_with($this->image, 'http')) {
            return $this->image;
        }
        return asset('storage/'.$this->image);
    }

    public function getNextAvailableDateAttribute(): ?string
    {
        if ($this->status === 'available') return null;
        $lastRental = $this->rentals()
            ->whereIn('status', ['confirmed','ongoing'])
            ->orderByDesc('end_date')
            ->first();
        return $lastRental
            ? $lastRental->end_date->addDay()->format('d/m/Y')
            : null;
    }

    public function isAvailable(): bool
    {
        return $this->status === 'available';
    }
}