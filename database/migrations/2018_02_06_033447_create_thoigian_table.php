<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateThoigianTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('thoigian', function (Blueprint $table) {
            $table->string('ltg_maso');
            $table->string('bgd_maso');
            $table->date('tg_batdau');
            $table->date('tg_ketthuc');
            $table->primary(['ltg_maso','bgd_maso']);
            $table->foreign('ltg_maso')
                  ->references('ltg_maso')
                  ->on('loaithoigian')
                  ->onDelete('cascade');
            $table->foreign('bgd_maso')
                  ->references('user_id')
                  ->on('users')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('thoigian');
    }
}
