<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Lottery;
use App\Models\Ticket;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function show()
    {
        $userId = Auth::id();

        // Fetch tickets and related lottery data for the logged-in user
        $tickets = Ticket::where('user_id', $userId)
            ->with('lottery')
            ->orderBy('id', 'desc')
            ->limit(8)
            ->get();

            // print_r(($tickets[0]));die;

        $undrawnLottery = Lottery::where('drawn', false)->first();
        $current_time = Carbon::now();

        // If no undrawn lottery exists, create one
        if (!$undrawnLottery) {
            $undrawnLottery = Lottery::create([
                'winning_number' => null,
                'drawn' => false,
                'draw_time' => null,
            ]);
            $timeRemaining = 30 * 60; // 30 minutes in seconds
        } else {
            // Calculate the time remaining
            $timeElapsed = $current_time->diffInSeconds($undrawnLottery->created_at);
            $timeRemaining = 30 * 60 - $timeElapsed;

            // Automatically withdraw the lottery if 30 minutes have passed
            if ($timeRemaining <= 0) {
                $this->withdrawLottery($undrawnLottery);
                $undrawnLottery = Lottery::create([
                    'winning_number' => null,
                    'drawn' => false,
                    'draw_time' => null,
                ]);
                $timeRemaining = 30 * 60; // Reset timer for the new lottery
            }
        }

        return view('profile', compact('tickets', 'undrawnLottery', 'timeRemaining', 'current_time'));
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
    }
}
