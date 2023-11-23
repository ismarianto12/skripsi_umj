<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tmrap extends Model
{
    use HasFactory;

    protected $table = 'tmrap';
    public $incrementing = false;
    public $datetime = false;
    protected $guarded = [];


    public function Tmproyek()
    {
        return $this->belongsTo(Tmproyek::class);
    }
    public function Tmbangunan()
    {
        return $this->belongsTo(Tmbangunan::class);
    }
    public function Tmjenisrap()
    {
        return $this->belongsTo(Tmjenisrap::class);
    }
    public function User()
    {
        return $this->belongsTo(User::class);
    }
}
