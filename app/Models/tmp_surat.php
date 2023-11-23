<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use boot;

class tmp_surat extends Model
{
    use HasFactory;

    protected $table = 'tmp_surat';
    public $incrementing = false;
    public $datetime = false;
    protected $guarded = [];


    public static function boot()
    {
        parent::boot();

        self::created(function ($model) {
            $model->created_at = date('Y-m-d H:i:s');
        });

        self::updating(function ($model) {
            $model->updated_at = date('Y-m-d H:i:s');
        });
    }
}
