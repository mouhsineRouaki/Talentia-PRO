<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Conversation extends Model
{
    protected $table ='conversation';
    protected $fillable = [
        'user_one_id',
        'user_two_id',
        'user_one_deleted_at',
        'user_two_deleted_at',
        'user_one_archived_at',
        'user_two_archived_at',
    ];

    public function message(){
        return $this->hasMany(Message::class ,'conversation_id');
    }

    public function userOne(){
        return $this->belongsTo(User::class , 'user_one_id');
    }

    public function userTow(){
        return $this->belongsTo(User::class ,'user_two_id');
    }

    public function lastMessage()
    {
        return $this->hasOne(Message::class, 'conversation_id')->latestOfMany();
    }
}
