<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVideoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('video', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('ceremony_id');
            $table->foreign('ceremony_id')->references('id')->on('ceremonies')->onDelete('cascade');

            $table->string('vimeo_code');
            $table->string('vimeo_url');
            $table->string('vimeo_rmtp_url')->nullable();
            $table->string('vimeo_rmtp_key')->nullable();

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
        Schema::dropIfExists('video');
    }
}
