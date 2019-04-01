<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGalerisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('galeris', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('portofolio_id')->unsigned();
            $table->foreign('portofolio_id')->references('id')->on('portofolios')
                ->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->string('nama');
            $table->text('deskripsi');
            $table->text('photo')->nullable();
            $table->text('video')->nullable();
            $table->text('thumbnail')->nullable();
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
        Schema::dropIfExists('galeris');
    }
}
