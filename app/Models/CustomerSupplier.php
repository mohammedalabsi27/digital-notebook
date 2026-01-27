<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerSupplier extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable
     *
     * @var array<int, string>
     */
    protected $guarded = ['id'];
    

    public function shop()
    {
        return $this->belongsTo(Shop::class);
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

     public function balance(): float
    {
        // مجموع الديون (debit)
        $debits = $this->transactions()->where('type', 'debit')->sum('amount');
        // مجموع الدفعات (credit)
        $credits = $this->transactions()->where('type', 'credit')->sum('amount');

        // حساب الرصيد بناءً على النوع
        if ($this->type === 'customer') {
            // رصيد العميل = الديون - الدفعات (إذا كان موجبًا فهو مدين)
            return $debits - $credits;
        } elseif ($this->type === 'supplier') {
            // رصيد المورد = الدفعات - الديون (إذا كان موجبًا فهو مستحق للمورد)
            return $credits - $debits;
        }

        return 0.0;
    }
}
