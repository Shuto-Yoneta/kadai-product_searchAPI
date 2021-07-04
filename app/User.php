<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    
    /**
     * このユーザが検索する商品。（ Productモデルとの関係を定義）
     */
    public function products()
    {
        return $this->hasMany(Product::class);
    }
    
    /**
     * （追加）このユーザが欲している商品。（ Productモデルとの関係を定義）
     */
    public function wants()
    {
        return $this->belongsToMany(Product::class, 'user_want', 'user_id', 'want_id')->withTimestamps();
    }
    
    /**
     * 指定された $userIdのユーザーの投稿がすでに欲しいものに追加しているProductかどうか調べる。お気に入り中ならtrueを返す。
     *
     * @param  int  $userId
     * @return bool
     */
    public function is_wanting($ProductId)
    {
        // フォロー中のユーザの中に $userIdのものが存在するか
        return $this->wants()->where('want_id', $ProductId)->exists();
    }
    
    /**
     * （追加）
     * $ProductIdで指定された商品を欲しい登録する
     * 中間テーブルのレコードを登録する。
     * @param  int  $ProductId
     * @return bool
     */
    public function want($ProductId)
    {
        // すでに欲しいっているかの確認
        $exist = $this->is_wanting($ProductId);

        if ($exist) {
            // すでに欲していれば何もしない
            return false;
        } else {
            // 欲していなければであればお気に入りする
            $this->wants()->attach($ProductId);
            return true;
        }
    }
    
    /**
     * （追加）
     * $ProductIdで指定された商品を欲しい削除する
     *中間テーブルのレコードを削除する。
     * @param  int  $ProductId
     * @return bool
     */
    public function unwant($ProductId)
    {
        // すでに欲しいっているかの確認
        $exist = $this->is_wanting($ProductId);

        if ($exist) {
            // すでに欲していれば欲しいを外す
            $this->wants()->detach($$ProductId);
            return true;
        } else {
            // 欲してなければ何もしない
            return false;
        }
    }

    /**
     * このユーザに関係するモデルの件数をロードする。
     *  欲しい商品の数を取得
     */
    public function loadRelationshipCounts()
    {
        $this->loadCount(['products','wants']);
    }
}
