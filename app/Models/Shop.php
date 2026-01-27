<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shop extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable
     *
     * @var array<int, string>
     */
    protected $guarded = ['id'];

    /**
     * Get the user that owns the shop.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the customers for the shop.
     */
    public function customersSuppliers()
    {
        return $this->hasMany(CustomerSupplier::class);
    }

    /**
     * Get the transactions for the shop.
     */
    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }
}
