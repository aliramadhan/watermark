<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQueueSignaturesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('queue_signatures', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id');
            $table->string('file_path');
            $table->string('file_name');
            $table->string('file_size');
            $table->string('total_page');
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
        Schema::dropIfExists('queue_signatures');
    }
}
