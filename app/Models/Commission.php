<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Commission extends Model
{
    public function attributes()
    {
        return $this->hasMany(CommissionAttributes::class);
    }
}
