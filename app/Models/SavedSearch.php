<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SavedSearch extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'name', 'filter_data'
    ];

    /**
     * Foreign key for user_id
     *
     * @return Model
     */
    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
}
