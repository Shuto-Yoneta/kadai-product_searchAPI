<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = ['imageUrl','productUrl','productname','productprice'];

    /**
     * この商品を検索するユーザ。（ Userモデルとの関係を定義）
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    /**
     * （追加）この商品が欲しいユーザ。（Userモデルとの関係を定義）
     */
    public function favorite_users()
    {
        return $this->belongsToMany(User::class, 'user_want', 'want_id', 'user_id')->withTimestamps();
    }
}
