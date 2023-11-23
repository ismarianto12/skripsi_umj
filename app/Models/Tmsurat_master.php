<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tmsurat_master extends Model
{
    use HasFactory;
    
    protected $table = 'tmsurat_master';
    public $incrementing = false;
    public $datetime = false;
    protected $guarded = [];
    public $timestamps = false;
}
