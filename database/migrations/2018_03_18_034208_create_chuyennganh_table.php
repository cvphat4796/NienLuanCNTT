<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateChuyennganhTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('chuyennganh', function (Blueprint $table) {
            $table->string('ngh_id');
            $table->string('cn_ten');
            $table->foreign('ngh_id')
                  ->references('ngh_id')
                  ->on('nganhhoc')
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
        Schema::dropIfExists('chuyennganh');
    }
}
