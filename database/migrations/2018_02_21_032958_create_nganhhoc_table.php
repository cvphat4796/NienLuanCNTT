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
            $table->float('ngh_diemcu');
            $table->float('ngh_diemmoi');
            $table->integer('ngh_diachi');
            $table->string('ngh_bachoc');
            $table->string('dh_maso');
            $table->primary('ngh_id');
            $table->foreign('dh_maso')
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
        Schema::dropIfExists('nganhhoc');
    }
}
