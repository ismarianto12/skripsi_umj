<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Surat_report extends Model
{
    use HasFactory;

    protected $table = 'surat_report';
    public $incrementing = false;
    public $datetime = false;
    protected $guarded = [];
}
