<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tmbangunan extends Model
{
    use HasFactory;

    protected $table = 'tmbangunan';
    public $incrementing = false;
    public $datetime = false;
    protected $guarded = [];

    public function User()
    {
        return $this->belongsTo(User::class);
    }
    public function Tmproyek()
    {
        return $this->belongsTo(Tmproyek::class);
    }
}
