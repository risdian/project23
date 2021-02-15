<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Withdrawal extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'request_amount',
        'request_date',
        'account_number',
        'bank_name',
        'account_name',

        'status',

        'pic_id',
        'approval_date',
        'approval_amount',
        'transaction_id',
        'transaction_date',
    ];

    public function user()
    {

        return $this->belongsTo(User::class, 'user_id');

    }

    public function pic()
    {

        return $this->belongsTo(User::class, 'pic_id');

    }


}
