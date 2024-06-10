<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUniqueConstraintToLotteryIdInTicketUserWinnersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
{
    Schema::table('ticket_user_winners', function (Blueprint $table) {
        $table->unique('lottery_id');
    });
}

public function down()
{
    Schema::table('ticket_user_winners', function (Blueprint $table) {
        $table->dropUnique('ticket_user_winners_lottery_id_unique');
    });
}

}
