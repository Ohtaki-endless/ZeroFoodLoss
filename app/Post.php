<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use SoftDeletes;
    
    public function comments(){
        return $this->hasMany('App\Comment');
    }
    
    public function users(){
        return $this->belongsToMany('App\User')->withTimestamps();
    }
    
    public function orderdetails(){
        return $this->hasMany('App\OrderDetail');
    }
    
    protected $fillable = [
        'title',
        'body',
        'price',
        'quantity',
        'limit'
    ];
    
    public function getPaginateByLimit(int $limit_count = 5)
    {
        // created_atで作成順に並べたあと、limitで件数制限をかける
        return $this->orderBy('created_at', 'DESC')->paginate($limit_count);
    }
}
