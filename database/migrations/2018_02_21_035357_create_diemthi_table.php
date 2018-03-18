<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDiemthiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('diemthi', function (Blueprint $table) {
            $table->string('hs_maso');
            $table->string('mh_maso');
            $table->float('dt_diemso')->nullable(true);
            $table->primary(['hs_maso','mh_maso']);
            $table->foreign('hs_maso')
                  ->references('hs_maso')
                  ->on('hocsinh')
                  ->onDelete('cascade');
            $table->foreign('mh_maso')
                  ->references('mh_maso')
                  ->on('monhoc')
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
        Schema::dropIfExists('diemthi');
    }
}
