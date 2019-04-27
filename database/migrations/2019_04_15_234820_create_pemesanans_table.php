<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePemesanansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pemesanans', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')
                ->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->integer('layanan_id')->unsigned();
            $table->foreign('layanan_id')->references('id')->on('layanans')
                ->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->integer('studio_id')->unsigned()->nullable();
            $table->foreign('studio_id')->references('id')->on('studios')
                ->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->integer('payment_id')->unsigned()->nullable();
            $table->foreign('payment_id')->references('id')->on('payment_method')
                ->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->dateTime('start');
            $table->dateTime('end')->nullable();
            $table->text('judul');
            $table->integer('hours')->nullable();
            $table->integer('qty')->nullable();
            $table->text('meeting_location')->nullable();
            $table->text('deskripsi')->nullable();
            $table->text('total_payment');
            $table->string('payment_type')->nullable();
            $table->text('payment_proof')->nullable();
            $table->dateTime('date_payment')->nullable();
            $table->integer('status_payment');
            $table->boolean('isAbort')->default(false);
            $table->boolean('isAccept')->default(false);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pemesanans');
    }
}
