<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Draw;
use App\Models\Ticket;
use Carbon\Carbon;

class DrawController extends Controller
{
    public function index()
    {
        $draws = Draw::orderBy('draw_time', 'desc')->take(10)->get();
        return view('draws.index', compact('draws'));
    }

    public function draw()
    {
        $current_time = Carbon::now();
        $last_draw_time = Draw::max('draw_time');

        if (!$last_draw_time || $current_time->diffInMinutes($last_draw_time) >= 30) {
            $winningNumber = str_pad(mt_rand(0, 99), 2, '0', STR_PAD_LEFT);
            Draw::create(['winning_number' => $winningNumber, 'draw_time' => $current_time]);

            // Clear old tickets
            Ticket::truncate();
        }

        return redirect()->back()->with('message', 'Lottery Drawn');
    }
}
