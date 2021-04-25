<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Spu;
use App\Models\CartItem;

class Sku extends Model
{
    
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'sku';


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'users_id',
        'spu_id',
        'name',
        'price',
        'specification',
        'stock',
        'image'
    ];

    /**
     * The model's default values for attributes.
     *
     * @var array
     */
    protected $attributes = [
        'name' => '',
        'specification' => '',
        'image' => '',
    ];

    public function spu()
    {
        return $this->belongsTo(
            Spu::class,
        );
    }

    public function cart()
    {
        return $this->hasMany(
            CartItem::class,
        );
    }

    public function comment()
    {
        return $this->hasMany(
            Comment::class,
        );
    }

    protected static function boot()
    {
        parent::boot();
        static::deleting(function ($cartItem) {
            $cartItem->cart()->forcedelete();
        });
        static::deleting(function ($comment) {
            $comment->comment()->forcedelete();
        });
    }
}
