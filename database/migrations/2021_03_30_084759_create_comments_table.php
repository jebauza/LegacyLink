<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comments', function (Blueprint $table) {
            $table->id();

            $table->string('title')->nullable();
            $table->text('message')->nullable();
            $table->string('path_file')->nullable();
            $table->string('type_file')->nullable();
            $table->boolean('approved')->default(false);

            $table->unsignedBigInteger('profile_id');
            $table->foreign('profile_id')->references('id')->on('deceased_profiles')->onDelete('cascade');

            $table->boolean('public')->default(true);

            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');

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
        Schema::dropIfExists('comments');
    }
}
