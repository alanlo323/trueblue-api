<?php

namespace App\Models;

use Gloudemans\Shoppingcart\Contracts\Buyable;
use Illuminate\Database\Eloquent\Model;
use Vinkla\Hashids\Facades\Hashids;

/** @mixin \Eloquent */
class Product extends Model implements Buyable
{
    protected $fillable = ['name', 'description', 'price', 'is_variant'];

    protected $dates = ['published_at'];

    protected $appends = ['rating'];

    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

    public function variants()
    {
        return $this->belongsToMany(
            Product::class,
            'product_variant',
            'product_id',
            'product_variant_id'
        );
    }

    public function favourites()
    {
        return $this->morphMany(Favourable::class, 'favourable');
    }

    public function reviews()
    {
        return $this->morphMany(Review::class, 'reviewable');
    }

    public function attributes()
    {
        return $this->belongsToMany(ProductAttribute::class)
            ->withPivot('value')
            ->using(ProductAttributePivot::class);
    }

    public function getRatingAttribute()
    {
        return $this->reviews()->approved()->avg('rating');
    }

    /**
     * Get the identifier of the Buyable item.
     *
     * @return int|string
     */
    public function getBuyableIdentifier($options = null)
    {
        return Hashids::encode($this->getKey());
    }

    /**
     * Get the description or title of the Buyable item.
     *
     * @return string
     */
    public function getBuyableDescription($options = null)
    {
        return $this->description ?? $this->name;
    }

    /**
     * Get the price of the Buyable item.
     *
     * @return float
     */
    public function getBuyablePrice($options = null)
    {
        return $this->price;
    }
}
