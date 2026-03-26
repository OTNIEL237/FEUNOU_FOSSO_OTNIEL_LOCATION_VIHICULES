<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contract extends Model
{
    protected $fillable = [
        'rental_id', 'contract_number',
        'signed_at', 'deposit_amount', 'status', 'terms'
    ];

    public function rental()
    {
        return $this->belongsTo(Rental::class);
    }
}