<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CourierRates extends Model
{
    /**
     * @var string
     */
    protected $table = 'courier_rates';

    /**
     * @var array
     */
    protected $fillable = ['courier_id', 'country', 'region', 'zip_from', 'zip_to', 'weight_from', 'weight_to', 'price'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function courier()
    {
        return $this->belongsTo(courier::class);
    }
}
