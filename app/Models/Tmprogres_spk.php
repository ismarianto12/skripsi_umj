<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tmprogres_spk extends Model
{
    use HasFactory;

    protected $table = 'tmprogres_spk';
    public $incrementing = false;
    public $datetime = false;
    protected $guarded = [];

    public function User()
    {
        return $this->belongsTo(User::class);
    }
    public function Tmrspk()
    {
        return $this->belongsTo(Tmrspk::class);
    }
    // public function Tmrspk()
    // {
    //     return $this->belongsTo(Tmrspk::class);
    // }

}
