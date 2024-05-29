<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Lottery;
use Carbon\Carbon;


class LotteryController extends Controller
{
    public function index()
    {
        $lotteries = Lottery::orderBy('created_at', 'desc')->take(10)->get();
        return view('lotteries.index', compact('lotteries'));
    }

    public function draw()
    {
        $current_time = Carbon::now();
        $last_lottery = Lottery::where('drawn', true)->orderBy('draw_time', 'desc')->first();

        if (!$last_lottery || $current_time->diffInMinutes($last_lottery->draw_time) >= 30) {
            // Create a new lottery if no recent drawn lottery or the last draw was more than 30 minutes ago
            $lottery = Lottery::create([
                'winning_number' => null,
                'drawn' => false,
                'draw_time' => null,
            ]);
        } else {
            // Update the existing lottery
            $winningNumber = str_pad(mt_rand(0, 99), 2, '0', STR_PAD_LEFT);
            $last_lottery->update([
                'winning_number' => $winningNumber,
                'drawn' => true,
                'draw_time' => $current_time,
            ]);

            // Create a new lottery after the previous one is drawn
            Lottery::create([
                'winning_number' => null,
                'drawn' => false,
                'draw_time' => null,
            ]);
        }

        return redirect()->back()->with('message', 'Lottery Drawn');
    }
}
