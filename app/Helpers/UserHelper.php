<?php
namespace App\Helpers;
use Illuminate\Support\Facades\Cache;
class UserHelper{
    //verification de user si en ligne
    public static function isUserOnline($userId): bool
    {
        return Cache::has("user-online-{$userId}");
    }
    //get last seen de user
    public static function getLastSeen($user)
    {
        if (!$user->last_seen) {
            return 'Never';
        }
        
        if (self::isUserOnline($user->id)) {
            return 'Online now';
        }
        
        return $user->last_seen->diffForHumans();
    }
}