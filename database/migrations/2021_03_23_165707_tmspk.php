<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Tmspk extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tmrspk', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('tmproyek_id');
            $table->string('tmbangunan_id');
            $table->string('tmvendor_id');
            $table->string('tmjenisrap_id');
            $table->string('no_spk');
            $table->string('pekerjaan');
            $table->string('spk_volume');
            $table->string('satuan');
            $table->double('spk_harga_satuan', 14, 7);
            $table->double('spk_jumlah_harga', 14, 7);
            $table->double('spk_total_harga', 14, 7);
            $table->date('tanggal');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
