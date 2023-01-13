<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Class CreateCurriculumsTable - Curriculums Migration
 */
return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('curriculums', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('name');
            $table->string('mother_name');
            $table->string('father_name');
            $table->date('birth');
            $table->string('cpf');
            $table->string('cep');
            $table->string('city');
            $table->string('district');
            $table->string('address');
            $table->string('phone');
            $table->unsignedBigInteger('role_id');
            $table->text('experience');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('role_id')->references('id')->on('roles');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('curriculums');
    }
};
