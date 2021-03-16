<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Courier extends Model
{
    /**
     * @var string
     */
    protected $table = 'couriers';

    /**
     * @var array
     */
    protected $fillable = ['name', 'shipping_method',];

    public function rates()
    {
        return $this->hasMany(CourierRates::class);
    }
}
