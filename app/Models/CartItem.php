<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Sku;

class CartItem extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'cart_items';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'users_id',
        'sku_id',
        'amount',
        'image',
    ];

    /**
     * The model's default values for attributes.
     *
     * @var array
     */
    protected $attributes = [
        'image' => '',
    ];

    public function sku()
    {
        return $this->belongsTo(
            Sku::class,
        );
    }
}
