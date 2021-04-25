<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Sku;

class Comment extends Model
{
    
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'comment';


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'users_id',
        'sku_id',
        'comment',
    ];

    /**
     * The model's default values for attributes.
     *
     * @var array
     */
    protected $attributes = [
        'comment' => '',
    ];

    public function sku()
    {
        return $this->belongsTo(
            Sku::class,
        );
    }
}
