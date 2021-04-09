<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Spu extends Model
{
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
        'users_id',
        'name',
        'description',
        'image'
    ];

    /**
     * The model's default values for attributes.
     *
     * @var array
     */
    protected $attributes = [
        'name' => '',
        'image' => '',
    ];
}
