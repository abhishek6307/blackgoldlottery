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
        
        // Fetch undrawn lottery
        $undrawnLottery = Lottery::where('drawn', false)->first();
        
        // If no undrawn lottery exists, create one
        if (!$undrawnLottery) {
            $undrawnLottery = Lottery::create([
                'winning_number' => null,
                'drawn' => false,
                'draw_time' => null,
            ]);
            $timeRemaining = 1 * 60;
        } else {
            // Calculate the time remaining
            $current_time = Carbon::now();
            $timeElapsed = $current_time->diffInSeconds($undrawnLottery->created_at);
            $timeRemaining = 1 * 60 - $timeElapsed;
            
            if ($timeRemaining <= 0) {
                // Draw the lottery
                $winningNumber = str_pad(mt_rand(0, 99), 2, '0', STR_PAD_LEFT);
                $undrawnLottery->update([
                    'winning_number' => $winningNumber,
                    'drawn' => true,
                    'draw_time' => $current_time,
                ]);
                $this->withdrawLottery($undrawnLottery, $winningNumber);
                $undrawnLottery = Lottery::create([
                    'winning_number' => null,
                    'drawn' => false,
                    'draw_time' => null,
                ]);
                $timeRemaining = 1 * 60;
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
        
        $winnersToday = TicketUserWinner::whereDate('created_at', $today)->orderBy('created_at', 'desc')->get();
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
    private function withdrawLottery($lottery, $winningNumber)
{
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
            'winner_name' => DB::table('users')->where('id', $ticket->user_id)->value('name'),
            'winning_amount' => 110, // This needs to be defined or calculated
        ]);
    }
}
}
