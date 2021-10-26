<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStaffLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('staff_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('staff_id')->constraint('staff')->cascadeOnDelete();
            $table->foreignId('item_id');
            $table->string('item_type');
            $table->string('activity');
            $table->datetime('time')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('staff_logs');
    }
}
