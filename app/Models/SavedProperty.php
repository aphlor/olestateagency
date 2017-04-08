<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SavedProperty extends Model
{
    /**
     * Override the table name because it is not a conventional plural.
     *
     * @var array
     */
    protected $table = 'saved_properties';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['user_id', 'property_id'];

    /**
     * Foreign key for user
     *
     * @return Model
     */
    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    /**
     * Foreign key for property listing
     *
     * @return Model
     */
    public function property()
    {
        return $this->hasOne(Property::class, 'id', 'property_id');
    }
}
