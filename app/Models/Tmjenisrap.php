<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tmjenisrap extends Model
{
    use HasFactory;

    protected $table = 'tmjenisrap';
    public $incrementing = false;
    public $datetime = false;
    protected $guarded = [];
    public function User()
    {
        return $this->belongsTo(User::class);
    }
}
