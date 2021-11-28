<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Kyslik\ColumnSortable\Sortable;

class Post extends Model
{
    use SoftDeletes;
    // use Sortable; // 追加
    // public $sortable = ['id', 'access'];
    
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
    
    public function getPaginateByLimit(int $limit_count = 4)
    {
        // created_atで作成順に並べたあと、limitで件数制限をかける
        return $this->orderBy('created_at', 'DESC')->paginate($limit_count);
    }
    
    // アクセス数のカウント
    public function AccessCounter ($post)
    {
        // ページにアクセスするとaccessの値を１増やす
        $this->where('id', '=', $post)->increment('access');
    }
    
    
    public function order($order, int $limit_count = 4)
    {
        // ページの並べ替え処理
        if($order == 'access'){
            return $this->orderBy('access', 'desc')->paginate($limit_count);
        } else {
            return $this->orderBy('created_at', 'desc')->paginate($limit_count);
        }
    }
}
