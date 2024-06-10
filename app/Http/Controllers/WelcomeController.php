<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Lottery;
use Carbon\Carbon;
use App\Models\TicketUserWinner;
use App\Models\TicketPurchasedDetail;
use App\Models\Ticket;
use Illuminate\Support\Facades\DB;

class WelcomeController extends Controller
{
    public function index()
    {
        $undrawnLottery = Lottery::where('drawn', false)->first();         
        $current_time = Carbon::now();

        if ($undrawnLottery) {
            $undrawnLotteryId = $undrawnLottery->id;
            $activeLotteryTicketsCounts = TicketPurchasedDetail::where('lottery_id', $undrawnLotteryId)
                                                               ->sum('total_quantity');
        }

        if (!$undrawnLottery) {
            $undrawnLottery = Lottery::create([
                'winning_number' => null,
                'drawn' => false,
                'draw_time' => null,
            ]);
            $timeRemaining = 5 * 60;
            $undrawnLotteryId = $undrawnLottery->id;
            $activeLotteryTicketsCounts = TicketPurchasedDetail::where('lottery_id', $undrawnLotteryId)
                                                               ->sum('total_quantity');
        } else {
            // Calculate the time remaining
            $timeElapsed = $current_time->diffInSeconds($undrawnLottery->created_at);
            $timeRemaining = 5 * 60 - $timeElapsed;

            if ($timeRemaining <= 0) {
                $this->withdrawLottery($undrawnLottery);
                $undrawnLottery = Lottery::create([
                    'winning_number' => null,
                    'drawn' => false,
                    'draw_time' => null,
                ]);
                $timeRemaining = 5 * 60; // Reset timer for the new lottery
            }
        }

        return view('welcome', compact('undrawnLottery', 'timeRemaining', 'current_time', 'activeLotteryTicketsCounts'));
    }

    public function withdrawLottery($lottery)
    {
        $current_time = Carbon::now();
        $winningNumber = str_pad(mt_rand(0, 99), 2, '0', STR_PAD_LEFT);

        $lottery->update([
            'winning_number' => $winningNumber,
            'drawn' => true,
            'draw_time' => $current_time,
        ]);

        // Retrieve tickets and check for any digit match in the winning number
        $winningTickets = Ticket::where('lottery_id', $lottery->id)
                                ->get()
                                ->filter(function ($ticket) use ($winningNumber) {
                                    
                                    $winningDigits = str_split($winningNumber);
                                    $ticketNumbers = [
                                        str_split($ticket->win_num1),
                                        str_split($ticket->win_num2),
                                        str_split($ticket->win_num3),
                                        str_split($ticket->win_num4),
                                        str_split($ticket->win_num5),
                                    ];

                                    // Check for any matching digit
                                    foreach ($ticketNumbers as $ticketDigits) {
                                        print_r($ticketDigits);
                                        print_r($winningDigits);
                                        if (array_intersect($winningDigits, $ticketDigits)) {
                                            return true; // A matching digit found
                                        }
                                    }

                                    return false; // No matching digit
                                });
                                die;

        // Process each winning ticket
        foreach ($winningTickets as $ticket) {
           // Check if a record with the same lottery_id already exists
$existingWinner = TicketUserWinner::where('lottery_id', $lottery->id)->first();

if ($existingWinner) {
    // Update the existing record
    $existingWinner->update([
        'ticket_id' => $ticket->id,
        'user_id' => $ticket->user_id,
        'winner_number' => $winningNumber,
        'winner_name' => DB::table('users')->where('id', $ticket->user_id)->value('name'),
        'winning_amount' => $ticket->ticket_price * 10,
    ]);
} else {
    // Create a new record
    TicketUserWinner::create([
        'ticket_id' => $ticket->id,
        'user_id' => $ticket->user_id,
        'lottery_id' => $lottery->id,
        'winner_number' => $winningNumber,
        'winner_name' => DB::table('users')->where('id', $ticket->user_id)->value('name'),
        'winning_amount' => $ticket->ticket_price * 10,
    ]);
}

        }
    }
}
