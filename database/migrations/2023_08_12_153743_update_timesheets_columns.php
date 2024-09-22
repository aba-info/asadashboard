<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateTimesheetsColumns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('timesheets', function (Blueprint $table) {
            $table->integer('time_spent_hours')->change();
            $table->integer('time_spent_minutes')->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('timesheets', function (Blueprint $table) {
            // You can revert the changes here if needed
            $table->decimal('time_spent_hours', 5, 2)->change();
            $table->decimal('time_spent_minutes', 5, 2)->change();
        });
    }
}
