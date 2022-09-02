<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class IDStudMigration extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('i_d_stud_models', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('year');
        });
        Schema::create('i_d_subjects', function (Blueprint $table) {
            $table->id();
            $table->string('subject');
        });
        Schema::create('stud_grades', function (Blueprint $table) {
            $table->integer('id_student');
            $table->integer('id_subject');
            $table->integer('grade')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropifExists('i_d_stud_models');
        Schema::dropifExists('i_d_subjects');
        Schema::dropifExists('stud_grades');
    }
}
