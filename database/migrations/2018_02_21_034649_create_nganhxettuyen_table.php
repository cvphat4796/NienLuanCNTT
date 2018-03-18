<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNganhxettuyenTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('nganhxettuyen', function (Blueprint $table) {
            $table->string('khoi_maso');
            $table->string('ngh_id');
            $table->string('dh_maso');
            $table->primary(['khoi_maso','ngh_id']);            
            $table->foreign('dh_maso')
                  ->references('user_id')
                  ->on('users')
                  ->onDelete('cascade');
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
        Schema::dropIfExists('nganhxettuyen');
    }
}
