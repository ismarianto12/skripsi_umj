<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tmmonitoring_pembayaranspk extends Model
{
    use HasFactory;
    use HasFactory;

    protected $table = 'tmmonitoring_pembayaranspk';
    public $incrementing = false;
    public $datetime = false;
    protected $guarded = [];

    public function Tmrspk()
    {
        return $this->belongsTo(Tmrspk::class);
    }
    public function User()
    {
        return $this->belongsTo(User::class);
    }

    public function Tmprogres_spk()
    {
        return $this->belongsTo(Tmprogres_spk::class);
    }
}
