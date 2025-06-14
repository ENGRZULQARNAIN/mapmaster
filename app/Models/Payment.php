<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id', 'status', 'payment_via', 'receipt'
    ];

    public function customer()
    {
        return $this->belongsTo(User::class);
    }
}
