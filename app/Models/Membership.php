<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Membership extends Model
{

    protected $table = 'memberships';

    protected $fillable = [
        'user_id',
        'categoryCode',
        'billName',
        'billAmount',
        'total_amount',
        'refno',
        'status',
        'billcode',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
