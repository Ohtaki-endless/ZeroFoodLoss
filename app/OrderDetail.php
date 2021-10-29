<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    public function order()
    {
        return $this->belongsTo('App\Order');
    }
    
    public function post()
    {
        return $this->belongsTo('App\Post' , 'product_id');
    }
}
