<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class ChatController extends Controller
{
    public function getFriend(){
        $user = User::findOrFail(auth()->id());

        $amis = $user->amis ?? [];

        $amis_user = User::whereIn('id',$amis)->get();

        return view('chat.index' , compact('amis_user'));   
    }
    public function fetchMessage(){
        
    }

    public function sendMessage(){

    }
}
