<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHocsinhTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hocsinh', function (Blueprint $table) {
            $table->string('hs_maso');
            $table->string('thpt_maso');
            $table->string('kv_maso');
            $table->string('hs_cmnd');
            $table->date('hs_ngaysinh');
            $table->string('hs_gioitinh');
            $table->primary('hs_maso');
            $table->foreign('hs_maso')
                  ->references('user_id')
                  ->on('users')
                  ->onDelete('cascade');
            $table->foreign('thpt_maso')
                  ->references('user_id')
                  ->on('users')
                  ->onDelete('cascade');
            $table->foreign('kv_maso')
                  ->references('kv_maso')
                  ->on('khuvuc')
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
        Schema::dropIfExists('hocsinh');
    }
}
