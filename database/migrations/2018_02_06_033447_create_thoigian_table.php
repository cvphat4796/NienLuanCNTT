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
            $table->string('tg_maso');
            $table->string('user_id');
            $table->date('tg_batdau');
            $table->date('tg_ketthuc');
            $table->string('tg_mota');
            $table->primary('tg_maso');
            $table->foreign('user_id')
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
