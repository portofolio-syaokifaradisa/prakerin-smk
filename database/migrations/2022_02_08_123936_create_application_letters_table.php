<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateApplicationLettersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('application_letters', function (Blueprint $table) {
            $table->id();
            $table->string('letter_number')->nullable();
            $table->foreignId('agency_id')->constrained();
            $table->enum('status', ['DELIVERED', 'PENDING', 'COMPLETE'])->default('DELIVERED');
            $table->foreignId('student_id')->constrained();

            $table->string('start_date')->nullable();
            $table->string('end_date')->nullable();
            
            $table->text('response')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('application_letters');
    }
}
