<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ChatSession extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'initiating_user_id',
        'accepting_user_id',
        'subject',
        'completed',
    ];

    /**
     * Foreign key for initiating_user_id
     *
     * @return Model
     */
    public function initiating_user()
    {
        return $this->hasOne(User::class, 'id', 'initiating_user_id');
    }

    /**
     * Foreign key for accepting_user_id
     *
     * @return Model
     */
    public function accepting_user()
    {
        return $this->hasOne(User::class, 'id', 'accepting_user_id');
    }
}
