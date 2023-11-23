<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tmlevel extends Model
{
    use HasFactory;

    protected $table = 'tmlevel';
    public $incrementing = false;
    public $datetime = false;
    protected $guarded = [];
}
