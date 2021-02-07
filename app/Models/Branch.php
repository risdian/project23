<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
    /**
     * @var string
     */
    protected $table = 'branches';

    /**
     * @var array
     */
    protected $fillable = ['name', 'address', 'postcode','city', 'state', 'country', 'phone_number'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function products()
    {
        return $this->hasMany(Product::class, 'branch_id');
    }

}
