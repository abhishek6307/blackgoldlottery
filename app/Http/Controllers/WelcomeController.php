<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Lottery;
use Carbon\Carbon;
use App\Models\TicketUserWinner;
use App\Models\TicketPurchasedDetail;
use App\Models\Ticket;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

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
            $timeRemaining = 1 * 60;
            $undrawnLotteryId = $undrawnLottery->id;

            $activeLotteryTicketsCounts = TicketPurchasedDetail::where('lottery_id', $undrawnLotteryId)
        ->sum('total_quantity');
        } else {
            // Calculate the time remaining
            $timeElapsed = $current_time->diffInSeconds($undrawnLottery->created_at);
            $timeRemaining = 1 * 60 - $timeElapsed;

            
            if ($timeRemaining <= 0) {
                $this->withdrawLottery($undrawnLottery);
                $undrawnLottery = Lottery::create([
                    'winning_number' => null,
                    'drawn' => false,
                    'draw_time' => null,
                ]);
                $timeRemaining = 1 * 60; // Reset timer for the new lottery
            }
        }

        return view('welcome', compact('undrawnLottery', 'timeRemaining', 'current_time','activeLotteryTicketsCounts'));
    }


    private function withdrawLottery($lottery)
    {
        $current_time = Carbon::now();
        $winningNumber = str_pad(mt_rand(0, 99), 2, '0', STR_PAD_LEFT);
        $lottery->update([
            'winning_number' => $winningNumber,
            'drawn' => true,
            'draw_time' => $current_time,
        ]);

        

        // Retrieve tickets that match the winning number
        $winningTickets = Ticket::where('lottery_id', $lottery->id)
                                ->where(function ($query) use ($winningNumber) {
                                    $query->where('win_num1', $winningNumber)
                                        ->orWhere('win_num2', $winningNumber)
                                        ->orWhere('win_num3', $winningNumber)
                                        ->orWhere('win_num4', $winningNumber)
                                        ->orWhere('win_num5', $winningNumber);
                                })
                                ->get();

        // Process each winning ticket

        foreach ($winningTickets as $ticket) {
            // Create a winner entry in the ticket_user_winners table
            TicketUserWinner::create([
                'ticket_id' => $ticket->id,
                'user_id' => $ticket->user_id,
                'lottery_id' => $lottery->id,
                'winner_number' => $winningNumber,
                'winner_name' => DB::table('users')->where('id', $ticket->user_id)->value('name'), // Direct DB query to fetch user name
                'winning_amount' =>  $ticket->ticket_price * 10,
            ]);
        }
    }
    
}