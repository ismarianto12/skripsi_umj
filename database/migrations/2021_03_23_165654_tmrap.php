<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Tmrap extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('tmrap', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('tmproyek_id');
            $table->string('tmbangunan_id');
            $table->string('tmjenisrap_id');
            $table->string('pekerjaan');
            $table->double('volume', 15, 8);
            $table->string('satuan');
            $table->double('harga_satuan', 15, 8);
            $table->double('jumlah_harga', 15, 8);
            $table->string('user_id');
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
