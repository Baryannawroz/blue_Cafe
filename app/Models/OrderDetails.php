<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderDetails extends Model
{
    protected $fillable = [
        'order_id',
        'dish_id',
        'dish_type_id',
        'quantity',
        'net_price',
        'gross_price',
        'note',
        'discount',
        'is_printed'
    ];

    public function dish()
    {
        return $this->belongsTo(Dish::class);
    }

    public function dishType()
    {
        return $this->belongsTo(DishPrice::class);
    }
}
