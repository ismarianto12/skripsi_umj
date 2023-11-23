<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tr_surat_master extends Model
{
    use HasFactory; 
    protected $table = 'tr_surat_master';
    public $incrementing = false;
    public $datetime = false;
    protected $guarded = [];
}
