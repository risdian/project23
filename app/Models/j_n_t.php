<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class j_n_t extends Model
{
    protected $table = 'j_n_ts';

    protected $fillable = [
        'shipping_type', 'country', 'region', 'zip_from', 'zip_to', 'price', 'weight_from', 'weight_to'
    ];

}
