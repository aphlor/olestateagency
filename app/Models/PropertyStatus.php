<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PropertyStatus extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'status', 'marketable',
    ];
}
