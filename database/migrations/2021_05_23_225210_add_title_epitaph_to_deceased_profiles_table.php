<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTitleEpitaphToDeceasedProfilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('deceased_profiles', function (Blueprint $table) {
            $table->string('title_epitaph')->after('photo')->nullable();
            $table->text('message_epitaph')->after('title_epitaph')->nullable();
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
            $table->dropColumn('message_epitaph');
            $table->dropColumn('title_epitaph');
        });
    }
}
