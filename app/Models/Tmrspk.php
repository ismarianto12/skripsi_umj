<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tmrspk extends Model
{
    use HasFactory;

    protected $table = 'tmrspk';
    public $incrementing = false;
    public $datetime = false;
    protected $guarded = [];

    public function Tmrap()
    {
        return $this->belongsTo(Tmrap::class);
    }
    public function User()
    {
        return $this->belongsTo(User::class);
    }
    public function Trvendor()
    {
        return $this->belongsTo(Trvendor::class);
    }
}
