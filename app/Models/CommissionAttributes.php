<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CommissionAttributes extends Model
{
    /**
     * @var string
     */
    protected $table = 'commission_attributes';

    /**
     * @var array
     */
    protected $fillable = ['commission_id', 'range_start', 'range_end'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function commission()
    {
        return $this->belongsTo(commission::class);
    }
}
