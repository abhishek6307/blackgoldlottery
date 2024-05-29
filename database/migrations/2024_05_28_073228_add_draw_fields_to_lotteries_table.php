<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDrawFieldsToLotteriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
{
    Schema::table('lotteries', function (Blueprint $table) {
        $table->string('winning_number')->nullable();
        $table->boolean('drawn')->default(false);
        $table->timestamp('draw_time')->nullable();
    });
}

public function down()
{
    Schema::table('lotteries', function (Blueprint $table) {
        $table->dropColumn('winning_number');
        $table->dropColumn('drawn');
        $table->dropColumn('draw_time');
    });
}

}
