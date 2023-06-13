<?php

use App\Models\ApplicationLetter;
use App\Models\Student;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAttendancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('attendances', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Student::class)->constrained();
            $table->date('date');
            $table->time("in")->nullable();
            $table->time("out")->nullable();
            $table->boolean('isPermit')->default(false);
            $table->boolean('isAlpha')->default(false);
            $table->boolean('isSick')->default(false);
            $table->text('description')->nullable();
            $table->foreignIdFor(ApplicationLetter::class)->constrained();
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
        Schema::dropIfExists('attendances');
    }
}
