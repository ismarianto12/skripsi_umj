<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username',
        'name',
        'email',
        // 'tmproyek_id', 
        'tmlevel_id',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $appends = ['proyekid', 'levelid'];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getProyekIdAttribute()
    {
        $user_id = Auth::user()->id;
        $query = User::select('users.id', 'users.username', 'tmlevel.level', 'tmlevel.id as level_id')
            ->join('tmlevel', 'users.tmlevel_id', '=', 'tmlevel.id')
            ->where('users.id', $user_id)
            ->first();
        return $query->tmproyek_id;
    }

    public function getLevelidAttribute()
    {
        $user_id = Auth::user()->id;
        $query = User::select('users.id', 'users.username', 'tmlevel_id')
            ->where('users.id', $user_id)->first();
        return $query->tmlevel_id;
    }

    public function Tmlevel()
    {
        return $this->belongsTo(Tmlevel::class);
    }
    public function Tmproyek()
    {
        return $this->belongsTo(Tmproyek::class);
    }
}
