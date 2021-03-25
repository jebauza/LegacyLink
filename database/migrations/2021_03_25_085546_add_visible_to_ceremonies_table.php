<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddVisibleToCeremoniesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ceremonies', function (Blueprint $table) {
            $table->string('visible')->default('public')->after('profile_id')->comment("['family','close_friend','public']");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ceremonies', function (Blueprint $table) {
            $table->dropColumn('visible');
        });
    }
}
