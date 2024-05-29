<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemoveNumberFieldFromLotteriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('lotteries', function (Blueprint $table) {
            $table->dropColumn('number');
        });
    }

    public function down()
    {
        Schema::table('lotteries', function (Blueprint $table) {
            $table->string('number');
        });
    }
}
