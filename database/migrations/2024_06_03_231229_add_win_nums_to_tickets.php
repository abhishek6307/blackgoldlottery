<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddWinNumsToTickets extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tickets', function (Blueprint $table) {
            $table->integer('win_num1')->nullable();
            $table->integer('win_num2')->nullable();
            $table->integer('win_num3')->nullable();
            $table->integer('win_num4')->nullable();
            $table->integer('win_num5')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tickets', function (Blueprint $table) {
            $table->dropColumn('win_num1');
            $table->dropColumn('win_num2');
            $table->dropColumn('win_num3');
            $table->dropColumn('win_num4');
            $table->dropColumn('win_num5');
        });
    }
}
