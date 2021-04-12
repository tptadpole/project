<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
}
