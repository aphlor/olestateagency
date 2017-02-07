<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FeaturedProperty extends Model
{
    /**
     * Override the table name because it is not a conventional plural.
     *
     * @var array
     */
    protected $table = 'featured_properties';

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'property_id', 'display_order',
    ];

    /**
     * Foreign key for property
     *
     * @return Model
     */
    public function property()
    {
        return $this->hasOne(Property::class, 'id', 'property_id');
    }
}
