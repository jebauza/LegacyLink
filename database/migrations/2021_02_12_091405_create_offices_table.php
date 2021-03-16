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
            $table->string('name', 255);
            $table->string('cif', 100)->nullable();
            $table->string('address', 255);
            $table->string('extra_address', 255)->nullable();
            $table->string('city', 255)->nullable();
            $table->string('cp', 10)->nullable()->comment('Postal Code');
            $table->string('province', 255)->nullable();
            $table->string('country', 255)->nullable();

            $table->unsignedBigInteger('timezone_id')->nullable();
            $table->foreign('timezone_id')->references('id')->on('timezones')->onDelete('set null');

            $table->string('phone', 20)->nullable();
            $table->string('contact_person', 255)->nullable();
            $table->string('email', 100)->nullable();
            $table->decimal('latitude', 10, 8)->nullable();
            $table->decimal('longitude', 11, 8)->nullable();
            $table->boolean('is_active')->default(true);
            $table->bigInteger('created_by')->unsigned()->index();
            $table->bigInteger('updated_by')->unsigned()->index();

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
