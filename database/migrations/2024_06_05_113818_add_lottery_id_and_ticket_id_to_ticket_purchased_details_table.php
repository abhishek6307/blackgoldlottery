<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddLotteryIdAndTicketIdToTicketPurchasedDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ticket_purchased_details', function (Blueprint $table) {
            // Assuming both IDs are integers
            $table->unsignedBigInteger('lottery_id')->after('id'); // Use `after` to specify the position of the new column
            $table->unsignedBigInteger('ticket_id')->after('lottery_id');

            // Optional: Add foreign key constraints if these IDs reference other tables
            $table->foreign('lottery_id')->references('id')->on('lotteries')->onDelete('cascade');
            $table->foreign('ticket_id')->references('id')->on('tickets')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ticket_purchased_details', function (Blueprint $table) {
            // Drop foreign key constraints first if they were added
            $table->dropForeign(['lottery_id']);
            $table->dropForeign(['ticket_id']);

            // Then drop the columns
            $table->dropColumn(['lottery_id', 'ticket_id']);
        });
    }
}
