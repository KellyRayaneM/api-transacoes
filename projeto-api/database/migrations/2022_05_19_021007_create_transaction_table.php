<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id('id_transaction');
            $table->unsignedBigInteger('id_user_out')->nullable();
            $table->unsignedBigInteger('id_user_in')->nullable();
            $table->double('value');
            $table->softDeletes();
            $table->foreign('id_user_in')->references('id_user')->on('wallets')->onDelete('cascade');
            $table->foreign('id_user_out')->references('id_user')->on('wallets')->onDelete('cascade');
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
        Schema::dropIfExists('transaction');
    }
};
