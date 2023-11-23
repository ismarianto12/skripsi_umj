<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tmsurat_log extends Model
{
    use HasFactory;

    protected $table = 'tmsurat_log';
    public $incrementing = false;
    public $datetime = false;
    protected $guarded = [];
}
