<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Lottery;
use App\Models\TicketPurchasedDetail;
use App\Models\Ticket;
use App\Models\TicketUserWinner;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function show()
    {
        $today = Carbon::today();
        $userId = Auth::id();
        
        $current_time = Carbon::now();
        $undrawnLottery = Lottery::where('drawn', false)->first();         
        
        if (!$undrawnLottery) {
            // Create a new lottery with a random double-digit winning number
            $undrawnLottery = Lottery::create([
                'winning_number' => str_pad(mt_rand(0, 99), 2, '0', STR_PAD_LEFT),
                'drawn' => false,
                'draw_time' => null,
            ]);
            $timeRemaining = 5 * 60;
        } else {
            // Calculate the time remaining
            $timeElapsed = $current_time->diffInSeconds($undrawnLottery->created_at);
            $timeRemaining = 5 * 60 - $timeElapsed;

            if ($timeRemaining <= 0) {
                // Draw the current lottery and create a new one
                $this->withdrawLottery($undrawnLottery);
                $undrawnLottery = Lottery::create([
                    'winning_number' => str_pad(mt_rand(0, 99), 2, '0', STR_PAD_LEFT),
                    'drawn' => false,
                    'draw_time' => null,
                ]);
                $timeRemaining = 5 * 60; // Reset timer for the new lottery
            }
        }
        
        // Fetch tickets and related lottery data for the logged-in user
        $tickets = Ticket::where('user_id', $userId)
            ->with('lottery')
            ->orderBy('id', 'desc')
            ->limit(8)
            ->get();
    
        $activeLotteryTicketsCounts = TicketPurchasedDetail::where('lottery_id', $undrawnLottery->id)
            ->sum('total_quantity');
        
        $winnersToday = TicketUserWinner::whereDate('created_at', $today)
                                        ->orderBy('created_at', 'desc')
                                        ->get();
        $winnersCountToday = count($winnersToday);
        
        return view('profile', compact(
            'tickets',
            'undrawnLottery',
            'timeRemaining',
            'activeLotteryTicketsCounts',
            'winnersToday',
            'winnersCountToday'
        ));
    }

    public function withdrawLottery($lottery)
    {
        $current_time = Carbon::now();

        $lottery->update([
            'drawn' => true,
            'draw_time' => $current_time,
        ]);

        $winningNumber = $lottery->winning_number;
        $winningOnesDigit = $winningNumber % 10;

        // Retrieve tickets and check for any one's digit match in the winning number
        $winningTickets = Ticket::where('lottery_id', $lottery->id)
            ->get()
            ->filter(function ($ticket) use ($winningOnesDigit) {
                // Extract the one's digit of each ticket number
                $ticketOnesDigits = [
                    $ticket->win_num1 % 10,
                    $ticket->win_num2 % 10,
                    $ticket->win_num3 % 10,
                    $ticket->win_num4 % 10,
                    $ticket->win_num5 % 10,
                ];

                // Check if any of the ticket's one's digits match the winning one's digit
                return in_array($winningOnesDigit, $ticketOnesDigits);
            });

        // Process each winning ticket
        foreach ($winningTickets as $ticket) {
            $existingWinner = TicketUserWinner::where('lottery_id', $lottery->id)->first();

            if (!$existingWinner) {
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
