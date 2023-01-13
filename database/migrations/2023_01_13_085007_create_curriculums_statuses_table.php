<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('curriculums_statuses', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('status_id');
            $table->unsignedBigInteger('curriculum_id');
            $table->timestamps();

            $table->foreign('status_id')->references('id')->on('statuses');
            $table->foreign('curriculum_id')->references('id')->on('curriculums');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('curriculums_statuses');
    }
};
