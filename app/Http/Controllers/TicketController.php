<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ticket;
use App\Models\Lottery;
use App\Models\WinningNumber;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class TicketController extends Controller
{
    public function store(Request $request)
    {
        try {
            $request->validate([
                'number' => 'required|integer|between:0,99',
            ]);

            $undrawnLottery = Lottery::where('drawn', false)->first();
            $undrawnLotteryId = $undrawnLottery->id;

            $current_time = Carbon::now();
            $minute = $current_time->minute;

            // Check if the current time is within the first 25 minutes of the half-hour period
            if ($minute % 1 < 5) {
                $ticket = new Ticket();
                $ticket->number = str_pad($request->number, 2, '0', STR_PAD_LEFT);
                $ticket->ticketPrice = $request->ticketPrice;
                $ticket->lottery_id = $undrawnLotteryId;
                $ticket->save();

                // Generate winning numbers based on the ticket number
                $result = $this->generateWinningNumbers($ticket);

                if ($result['status'] === 'full') {
                    return response()->json(['error' => 'All Tickets are Saled ! Look for new one.'], 403);
                }

                return response()->json(['success' => 'Ticket purchased successfully!']);
            }

            return response()->json(['error' => 'Ticket purchase window closed.'], 403);
        } catch (\Exception $e) {
            Log::error('Ticket purchase error: ' . $e->getMessage());
            return response()->json(['error' => 'An error occurred during ticket purchase.'.$e], 500);
        }
    }

    private function generateWinningNumbers(Ticket $ticket)
    {
        $lotteryId = $ticket->lottery_id;
        $count = intval($ticket->number);
        $winningNumbers = [];

        // Fetch existing winning numbers for this lottery
        $existingWinningNumbers = WinningNumber::where('lottery_id', $lotteryId)->pluck('number')->toArray();

        // Check if all possible winning numbers are already assigned
        if (count($existingWinningNumbers) >= 99) {
            return ['status' => 'full'];
        }

        while (count($winningNumbers) < $count) {
            $number = str_pad(mt_rand(1, 99), 2, '0', STR_PAD_LEFT);

            if (!in_array($number, $existingWinningNumbers) && !in_array($number, $winningNumbers)) {
                $winningNumbers[] = $number;

                // Save winning number to the database
                WinningNumber::create([
                    'lottery_id' => $lotteryId,
                    'number' => $number,
                ]);

                $existingWinningNumbers[] = $number; // Add to existing numbers to prevent duplication
            }
        }

        return ['status' => 'success'];
    }
}
