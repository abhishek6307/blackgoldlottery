<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTicketPurchasedDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ticket_purchased_details', function (Blueprint $table) {
            $table->id();
            $table->string('payment_id');
            $table->string('order_id');
            $table->string('receipt');
            $table->integer('amount');
            $table->string('currency');
            $table->string('status');
            $table->string('method');
            $table->string('vpa')->nullable();
            $table->string('email');
            $table->string('contact');
            $table->integer('fee')->nullable();
            $table->integer('tax')->nullable();
            $table->string('description')->nullable();
            $table->unsignedBigInteger('user_id');
            $table->string('name');
            $table->string('role');
            $table->string('type');
            $table->integer('total_quantity');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ticket_purchased_details');
    }
}
