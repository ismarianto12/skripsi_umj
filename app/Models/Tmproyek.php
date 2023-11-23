<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tmproyek extends Model
{
    use HasFactory;

    protected $table = 'tmproyek';
    public $incrementing = false;
    public $datetime = false;
    protected $guarded = [];

    public function User()
    {
        return $this->belongsTo(User::class);
    }
    public function Tmbangunan()
    {
        return $this->belongsTo(Tmbangunan::class);
    }
}
