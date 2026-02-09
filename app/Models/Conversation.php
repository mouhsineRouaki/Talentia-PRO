<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Conversation extends Model
{
    protected $fillable = [
        'user_one_id',
        'user_two_id',
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
}
