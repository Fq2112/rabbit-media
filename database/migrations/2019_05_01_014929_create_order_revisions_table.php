<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderRevisionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_revisions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('log_id')->unsigned()->nullable();
            $table->foreign('log_id')->references('id')->on('order_logs')
                ->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->string('judul');
            $table->text('deskripsi');
            $table->boolean('isPass')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('order_revisions');
    }
}
