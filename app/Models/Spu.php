<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Spu;

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
        'image',
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

    public function sku()
    {
        return $this->hasMany(
            Sku::class,
        );
    }

    protected static function boot()
    {
        parent::boot();
        static::deleting(function ($spu) {
            $spu->sku()->delete();
        });
    }
}
