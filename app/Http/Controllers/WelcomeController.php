<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Lottery;
use Carbon\Carbon;

class WelcomeController extends Controller
{
    public function index()
    {
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

        return view('welcome', compact('undrawnLottery', 'timeRemaining', 'current_time'));
    }

    public function withdraw()
    {
        $undrawnLottery = Lottery::where('drawn', false)->first();
        if ($undrawnLottery) {
            $this->withdrawLottery($undrawnLottery);
            $newLottery = Lottery::create([
                'winning_number' => null,
                'drawn' => false,
                'draw_time' => null,
            ]);

            return response()->json([
                'newLottery' => $newLottery,
                'created_at' => $newLottery->created_at->format('H:i:s'),
                'timeRemaining' => 30 * 60
            ]);
        }

        return response()->json(['error' => 'No active lottery found.'], 400);
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
