<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $table = 'message';
    protected $fillable = [
        'sender_id',
        'conversation_id',
        'text',
        'attach',
    ];

    protected $casts = [
        'attach'=>'array',
    ];

    public function conversation(){
        return $this->belongsTo(Conversation::class , 'conversation_id');
    }

    public function sender(){
        return $this->belongsTo(User::class , 'sender_id');
    }
}
