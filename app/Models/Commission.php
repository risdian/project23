<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Commission extends Model
{
    /**
     * @var string
     */
    protected $table = 'commissions';

    /**
     * @var array
     */
    protected $fillable = ['user_id', 'status', 'start_date'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }


    public function attributes()
    {
        return $this->hasMany(CommissionAttributes::class);
    }
}
