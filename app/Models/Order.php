<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\OrderItem;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use SoftDeletes;
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'orders';


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'users_id',
        'name',
        'address',
        'phone',
        'total_amount',
        'status',
        'payment',
    ];

    /**
     * The model's default values for attributes.
     *
     * @var array
     */
    protected $attributes = [
        'name' => '',
        'address' => '',
        'status' => '',
        'payment' => '',
    ];

    public function orderItems()
    {
        return $this->hasMany(
            OrderItem::class
        );
    }

    protected static function boot()
    {
        parent::boot();
        static::deleting(function ($order) {
            $order->orderItems()->delete();
        });
    }
}
