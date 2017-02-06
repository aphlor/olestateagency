<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PropertyImage extends Model
{
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
        'property_id', 'display_order', 'image_filename', 'description',
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
