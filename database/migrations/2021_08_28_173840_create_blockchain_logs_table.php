<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBlockchainLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('blockchain_logs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('client_id')->index();
            $table->string('model_class');
            $table->string('model_id')->index();
            $table->unsignedBigInteger('timestamp');
            $table->longText('causer');
            $table->longText('data');
            $table->string('previous_hash');
            $table->string('hash');
            $table->unsignedBigInteger('nonce');
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
        Schema::dropIfExists('blockchain_logs');
    }
}
