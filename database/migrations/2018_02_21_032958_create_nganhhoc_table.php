<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNganhhocTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('nganhhoc', function (Blueprint $table) {
            $table->string('ngh_id');
            $table->string('ngh_maso');
            $table->string('ngh_ten');
            $table->float('ngh_diemchuan')->nullable(true);
            $table->integer('ngh_chitieu');
            $table->string('ngh_bachoc');
            $table->primary('ngh_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('nganhhoc');
    }
}
