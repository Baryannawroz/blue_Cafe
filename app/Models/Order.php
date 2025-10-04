<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'order_no',
        'table_id',
        'served_by',
        'kitchen_id',
        'user_id',
        'status',
        'payment',
        'vat',
        'change_amount',
        'discount'
    ];

    public function orderPrice()
    {
        return $this->hasMany(OrderDetails::class);
    }

    public function servedBy()
    {
        return $this->belongsTo(User::class, 'served_by');
    }

    public function kitchen()
    {
        return $this->belongsTo(User::class, 'kitchen_id');
    }

    public function table()
    {
        return $this->belongsTo(Table::class);
    }

    public function orderDetails()
    {
        return $this->hasMany(OrderDetails::class)->with('dish')->with('dishType');
    }
}
