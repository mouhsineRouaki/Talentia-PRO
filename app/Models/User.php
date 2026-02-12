<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\UserRole;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\RelationShip;
use Spatie\Permission\Traits\HasRoles;
use Spatie\Permission\Models\Role;
use Laravel\Cashier\Billable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasRoles, Billable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'nom',
        'prenom',
        'email',
        'role',
        'biographie' , 
        'image',
        'password'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'role' => UserRole::class,
        ];
    }
    public function hasAmi($idAmi): bool{
    return RelationShip::where('sender_id', auth()->id())
            ->where('reciever_id', $idAmi)
            ->exists()
        || RelationShip::where('reciever_id', auth()->id())
            ->where('sender_id', $idAmi)
            ->exists();
    }
    public function asTyped(): User
    {
        return match ($this->role) {
            UserRole::RECRUTEUR => Recruteur::query()->findOrFail($this->id),
            UserRole::RECHERCHEUR => Rechercheur::query()->findOrFail($this->id),
            default => $this,
        };
    }
    public function recruteur(){
        return $this->hasOne(\App\Models\Recruteur::class, 'user_id', 'id');
    }
    public function rechercheur(){
        return $this->hasOne(\App\Models\Rechercheur::class, 'user_id', 'id');
    }
    public function sentRelationships()
    {
        return $this->hasMany(\App\Models\Relationship::class, 'sender_id', 'id');
    }

    public function receivedRelationships()
    {
        return $this->hasMany(\App\Models\Relationship::class, 'reciever_id', 'id'); 
    }

    public function friends()
    {
        return $this->belongsToMany(
            \App\Models\User::class,
            'relationships',
            'sender_id',
            'reciever_id'
        )->wherePivot('status', 'ACCEPTED');
    }
    public function notifications(){
        return $this->hasMany(\App\Models\Notifications ,'user_id' , 'id');
    }


     public function assigneRole(string $role) {
        if (\Spatie\Permission\Models\Role::where('name', $role)->exists()) {
            $this->assignRole($role); // <-- now this works
        } else {
            // Optional: auto-create the role
            $newRole = \Spatie\Permission\Models\Role::create([
                'name' => $role,
                'guard_name' => 'web',
            ]);
            $this->assignRole($newRole);
        }
    }

}
