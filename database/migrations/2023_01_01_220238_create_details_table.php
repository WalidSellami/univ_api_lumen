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
        Schema::create('details', function (Blueprint $table) {
            $table->id('detail_id');
            $table->string('project_name');
            $table->year('year');
            $table->string('first_student_name');
            $table->string('second_student_name');
            $table->string('third_student_name');
            $table->string('supervisor_name');
            $table->decimal('supervisor_mark', 4, 2);
            $table->string('president_name');
            $table->decimal('president_mark', 4, 2);
            $table->string('examiner_name');
            $table->decimal('examiner_mark', 4, 2);
            $table->decimal('final_mark', 5, 3);
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('user_id')->on('users')->onDelete('cascade');
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
        Schema::dropIfExists('details');
    }
};
