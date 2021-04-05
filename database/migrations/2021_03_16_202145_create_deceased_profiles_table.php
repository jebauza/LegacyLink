<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDeceasedProfilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('deceased_profiles', function (Blueprint $table) {
            $table->id();
            $table->string('web_code')->nullable()->unique();
            $table->string("name",255);
            $table->string("last_name",255);
            $table->date("birthday");
            $table->date("death");
            $table->string('photo')->nullable();

            $table->unsignedBigInteger('adviser_id');
            $table->foreign('adviser_id')->references('id')->on('employees');

            $table->unsignedBigInteger('office_id');
            $table->foreign('office_id')->references('id')->on('offices');

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
        Schema::dropIfExists('deceased_profiles');
    }
}
