<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvitationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invitations', function (Blueprint $table) {
            $table->id();
            $table->string('token', 100);

            $table->unsignedBigInteger('profile_id');
            $table->foreign('profile_id')->references('id')->on('deceased_profiles')->onDelete('cascade');

            $table->string('name', 255)->nullable();
            $table->string('phone', 20)->nullable()->comment("Ej: +34622452579");
            $table->text('message');

            $table->unsignedBigInteger('from')->nullable();
            $table->foreign('from')->references('id')->on('users')->onDelete('set null');

            $table->unsignedBigInteger('to')->nullable();
            $table->foreign('to')->references('id')->on('users')->onDelete('set null');

            $table->string('role')->default('close_friend')->comment("('admin', 'family','close_friend')");
            $table->dateTime('used_by')->nullable();
            $table->json('sms_response')->nullable();

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
        Schema::dropIfExists('invitations');
    }
}
