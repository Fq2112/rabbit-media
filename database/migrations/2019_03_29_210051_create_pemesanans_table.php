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
            $table->bigIncrements('id');
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')
                ->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->integer('layanan_id')->unsigned();
            $table->foreign('layanan_id')->references('id')->on('layanans')
                ->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->integer('payment_id')->unsigned();
            $table->foreign('payment_id')->references('id')->on('payment_method')
                ->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->integer('qty')->nullable();
            $table->text('deskripsi')->nullable();
            $table->string('payment_code');
            $table->string('cc_number')->nullable();
            $table->string('cc_name')->nullable();
            $table->string('cc_expiry', '9')->nullable();
            $table->string('cc_cvc', '4')->nullable();
            $table->text('total_payment');
            $table->text('payment_proof')->nullable();
            $table->boolean('isPaid')->default(false);
            $table->dateTime('date_payment')->nullable();
            $table->boolean('isAbort')->default(false);
            $table->integer('admin_id')->unsigned()->nullable();
            $table->foreign('admin_id')->references('id')->on('admins')
                ->onUpdate('CASCADE')->onDelete('CASCADE');
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
