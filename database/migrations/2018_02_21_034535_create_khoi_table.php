<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateKhoiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('khoi', function (Blueprint $table) {
            $table->string('khoi_maso');
            $table->string('khoi_ten');
            $table->string('dh_maso');
            $table->primary('khoi_maso');
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
        Schema::dropIfExists('khoi');
    }
}
