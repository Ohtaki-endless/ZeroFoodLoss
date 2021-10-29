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
    ];
    
    public function getPaginateByLimit(int $limit_count = 5)
    {
        // updated_atで降順に並べたあと、limitで件数制限をかける
        return $this->orderBy('updated_at', 'DESC')->paginate($limit_count);
    }
}
