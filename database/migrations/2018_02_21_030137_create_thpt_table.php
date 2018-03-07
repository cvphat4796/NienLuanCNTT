<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateThptTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('thpt', function (Blueprint $table) {
           $table->string('thpt_maso');
            $table->string('sgd_maso');
            $table->primary('thpt_maso');
            $table->foreign('thpt_maso')
                  ->references('user_id')
                  ->on('users')
                  ->onDelete('cascade');
            $table->foreign('sgd_maso')
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
        Schema::dropIfExists('thpt');
    }
}
