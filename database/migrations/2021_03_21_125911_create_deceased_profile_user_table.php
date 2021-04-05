<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDeceasedProfileUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('deceased_profile_user', function (Blueprint $table) {
            $table->id();
            $table->boolean('declarant')->default(false);

            $table->unsignedBigInteger('profile_id');
            $table->foreign('profile_id')->references('id')->on('deceased_profiles')->onDelete('cascade');

            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            $table->string('role')->default('close_friend')->comment("('admin', 'family','close_friend')");
            $table->string('token', 80)->nullable();

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
        Schema::dropIfExists('deceased_profile_user');
    }
}
