<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->string('user_id');
            $table->string('user_pass');
            $table->string('user_name');
            $table->string('user_addr');
            $table->string('user_email')->nullable(true);
            $table->string('user_phone');
            $table->string('pq_maso');
            $table->primary('user_id');
            $table->foreign('pq_maso')
                  ->references('pq_maso')
                  ->on('phanquyen')
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
        Schema::dropIfExists('users');
    }
}
