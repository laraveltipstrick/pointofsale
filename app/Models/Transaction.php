<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'sales_type_id',
        'user_id',
        'customer_id',
        'name',
        'total',
        'discount',
        'tax',
        'payment_id',
        'status'
    ];

    public function detail()
    {
        return $this->hasMany(TransactionDetail::class, 'transaction_id');
    }
}
