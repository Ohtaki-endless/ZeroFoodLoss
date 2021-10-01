<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Comment extends Model
{
    use SoftDeletes;
    
    public function user(){
        return $this->belongsTo(\App\User::class, 'user_id');
    }
    
    protected $fillable = [
        'comment',
        'user_id',
        'post_id',
    ];
}
