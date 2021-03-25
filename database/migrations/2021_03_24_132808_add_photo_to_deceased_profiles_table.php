<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPhotoToDeceasedProfilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('deceased_profiles', function (Blueprint $table) {
            $table->string('photo')->nullable()->after('token');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('deceased_profiles', function (Blueprint $table) {
            $table->dropColumn('photo');
        });
    }
}
