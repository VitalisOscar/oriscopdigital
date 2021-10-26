<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateScreenPackagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('screen_packages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('screen_id')->constraint('screens')->cascadeOnDelete();
            $table->foreignId('package_id')->constraint('packages')->cascadeOnDelete();
            $table->string('type')->nullable();
            $table->integer('price');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('screen_packages');
    }
}
