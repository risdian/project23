<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    /**
     * @var string
     */
    protected $table = 'payments';

    /**
     * @var array
     */
    protected $fillable = ['user_id', 'start_date', 'end_date'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }


    public function attributes()
    {
        return $this->hasMany(PaymentAttribute::class);
    }
}
