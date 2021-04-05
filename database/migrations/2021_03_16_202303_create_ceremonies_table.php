<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCeremoniesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ceremonies', function (Blueprint $table) {
            $table->id();
            $table->boolean('main')->default(false);
            $table->dateTime('start')->nullable();
            $table->dateTime('end')->nullable();
            $table->string('room_name',100)->nullable();
            $table->text('additional_info')->nullable();
            $table->string('address',255)->nullable();
            $table->decimal('latitude', 10, 8)->nullable();
            $table->decimal('longitude', 11, 8)->nullable();

            $table->unsignedBigInteger('type_id')->nullable();
            $table->foreign('type_id')->references('id')->on('ceremony_types')->onDelete('set null');

            $table->unsignedBigInteger('profile_id');
            $table->foreign('profile_id')->references('id')->on('deceased_profiles')->onDelete('cascade');

            $table->string('visible')->default('public')->comment("['family','close_friend','public']");
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
        Schema::dropIfExists('ceremonies');
    }
}
