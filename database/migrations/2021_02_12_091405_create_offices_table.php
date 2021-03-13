<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOfficesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('offices', function (Blueprint $table) {
            $table->id();
            $table->string('code', 100);
            $table->string('name', 255);
            $table->string('cif', 100);
            $table->string('address', 255);
            $table->string('extra_address', 255)->nullable();
            $table->string('city', 255);
            $table->string('cp', 255)->nullable()->comment('Postal Code');
            $table->string('province', 255);
            $table->string('country', 255);
            $table->string('time_zone', 255);
            $table->string('phone', 20);
            $table->string('contact_person', 255)->nullable();
            $table->string('email', 100);
            $table->decimal('latitude', 10, 8);
            $table->decimal('longitude', 11, 8);
            $table->boolean('is_active')->default(true);

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
        Schema::dropIfExists('offices');
    }
}
