<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePortofoliosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('portofolios', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('jenis_id')->unsigned();
            $table->foreign('jenis_id')->references('id')->on('jenis_portofolios')
                ->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->string('nama');
            $table->text('deskripsi');
            $table->string('cover');
            $table->text('photos')->nullable();
            $table->text('videos')->nullable();
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
        Schema::dropIfExists('portofolios');
    }
}
