<?php

namespace App\Models;

use Illuminate\Support\Str;
use Laravel\Passport\HasApiTokens;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{

    use HasApiTokens;

    /**
     * @var string
     */
    protected $table = 'products';

    /**
     * @var array
     */
    protected $fillable = [
        'name',
        'user_id',
        'branch_id',
        'brand_id',
        'categories',
        'sku',
        'slug',
        'description',
        'quantity',
        'weight',
        'width',
        'length',
        'height',
        'price',
        'sale_price',
        'status',
        'featured',
        'counter',
        'cost',
    ];

    /**
     * @var array
     */
    protected $casts = [
        'quantity'      =>  'integer',
        'user_id'       =>  'integer',
        'branch_id'     =>  'integer',
        'brand_id'      =>  'integer',
        'categories'    =>  'integer',
        'status'        =>  'boolean',
        'featured'      =>  'boolean'
    ];

     /**
     * @param $value
     */
    public function setNameAttribute($value)
    {
        $this->attributes['name'] = $value;
        $this->attributes['slug'] = Str::slug($value);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category()
    {
        return $this->belongsTo(Category::class, 'categories');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function attributes()
    {
        return $this->hasMany(ProductAttribute::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function items()
    {
        return $this->hasMany(Item::class);
    }

    public function orders(){

        return $this->belongsToMany(Order::class)->withPivot(['id', 'price', 'quantity', 'tracking_status', 'tracking_number', 'tracking_datetime'])->withTimestamps();

    }

}
