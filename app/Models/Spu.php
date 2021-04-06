<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Spu extends Model
{
    //
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'spu';


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'seller_id',
        'name',
        'amount',
        'vote',
        'comment',
        'stock',
    ];

    /**
     * The model's default values for attributes.
     *
     * @var array
     */
    protected $attributes = [
        'name' => '',
        'comment' => '',
    ];
}
