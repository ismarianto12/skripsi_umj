<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Trvendor extends Model
{
    use HasFactory;

    protected $table = 'trvendor';
    public $incrementing = false;
    public $datetime = false;
    protected $guarded = [];

    public function User()
    {
        return $this->belongsTo(User::class);
    }
}
