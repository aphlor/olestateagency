<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AuditTrail extends Model
{
    /**
     * Override the table name because it is not plural.
     *
     * @var array
     */
    protected $table = 'audit_trail';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'table', 'user_id', 'action',
    ];

    /**
     * Foreign key for user
     *
     * @return Model
     */
    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
}
