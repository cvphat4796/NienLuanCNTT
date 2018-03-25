<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNguyenvongTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('nguyenvong', function (Blueprint $table) {
            $table->string('khoi_maso');
            $table->string('ngh_id');
            $table->string('hs_maso');
            $table->integer('nv_douutien');
            $table->integer('nv_kq')->nullable(true);
            $table->primary(['khoi_maso','ngh_id','hs_maso','nv_douutien']);
            $table->foreign('khoi_maso')
                  ->references('khoi_maso')
                  ->on('khoi')
                  ->onDelete('cascade');
            $table->foreign('ngh_id')
                  ->references('ngh_id')
                  ->on('nganhhoc')
                  ->onDelete('cascade');
            $table->foreign('hs_maso')
                  ->references('hs_maso')
                  ->on('hocsinh')
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
        Schema::dropIfExists('nguyenvong');
    }
}
