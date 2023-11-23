<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jenis_surat extends Model
{
    use HasFactory;
    protected $table = 'jenis_surat';
    public $incrementing = false;
    public $datetime = false;
    protected $guarded = [];
}
