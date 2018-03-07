<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateChitietkhoiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('chitietkhoi', function (Blueprint $table) {
            $table->string('khoi_maso');
            $table->string('mh_maso');
            $table->primary(['khoi_maso','mh_maso']);
            $table->foreign('khoi_maso')
                  ->references('khoi_maso')
                  ->on('khoi')
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
        Schema::dropIfExists('chitietkhoi');
    }
}
