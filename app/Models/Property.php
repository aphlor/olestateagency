<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Property extends Model
{
    use SoftDeletes;

    /**
     * Override the table name because it is not a conventional plural.
     *
     * @var array
     */
    protected $table = 'properties';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'subtitle',
        'description',
        'short_description',
        'bedrooms',
        'address_line_1',
        'address_line_2',
        'town',
        'county',
        'postcode',
        'vendor_user_id',
        'price',
        'price_format_id',
        'property_status_id',
    ];

    /**
     * Foreign key for vendor user
     *
     * @return Model
     */
    public function vendor()
    {
        return $this->hasOne(User::class, 'id', 'vendor_user_id');
    }

    /**
     * Foreign key for price format
     *
     * @return Model
     */
    public function priceFormat()
    {
        return $this->hasOne(PriceFormat::class, 'id', 'price_format_id');
    }

    /**
     * Foreign key for property status
     *
     * @return Model
     */
    public function propertyStatus()
    {
        return $this->hasOne(PropertyStatus::class, 'id', 'property_status_id');
    }

    /**
     * Foreign key for property images
     *
     * @return Model
     */
    public function propertyImage()
    {
        return $this->hasMany(PropertyImage::class, 'property_id', 'id');
    }
}
