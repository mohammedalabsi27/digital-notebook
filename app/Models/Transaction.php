<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable
     *
     * @var array<int, string>
     */
    protected $guarded = ['id'];

        /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'transaction_date' => 'date', // Cast transaction_date to a Carbon instance
    ];

    public function shop()
    {
        return $this->belongsTo(Shop::class);
    }   


    /**
     * Get the customer that owns the transaction.
     */
    public function customerSupplier()
    {
        return $this->belongsTo(CustomerSupplier::class);
    }

}
