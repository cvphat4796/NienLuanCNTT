<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateKhoinganhTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('khoinganh', function (Blueprint $table) {
            $table->string('khoi_maso');
            $table->string('ngh_id');
            $table->primary(['khoi_maso','ngh_id']);
            $table->foreign('khoi_maso')
                  ->references('khoi_maso')
                  ->on('khoi')
                  ->onDelete('cascade');
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
        Schema::dropIfExists('khoinganh');
    }
}
