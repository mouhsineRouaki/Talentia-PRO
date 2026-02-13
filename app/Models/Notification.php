<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Notification extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'relationships_id',
        'contenu',
        'date_envoyer',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function relationship()
    {
        return $this->belongsTo(RelationShip::class, 'relationships_id', 'id');
    }
}
