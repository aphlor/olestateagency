<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ChatMessage extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'chat_session_id',
        'message_text',
        'from_initiator',
    ];

    /**
     * Foreign key for chat_session_id
     *
     * @return Model
     */
    public function chat_session()
    {
        return $this->hasOne(ChatSession::class, 'id', 'chat_session_id');
    }
}
