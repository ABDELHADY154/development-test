<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'price', 'payment_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function payment()
    {
        return $this->belongsTo(Payment::class, 'payment_id');
    }
    public function products()
    {
        return $this->belongsToMany(Product::class, 'order_product')->withPivot('id', 'order_id', 'product_id');
    }
}
