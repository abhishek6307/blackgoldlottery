<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Lottery;
use App\Models\Ticket;
use App\Models\TicketUserWinner;
use App\Models\TicketPurchasedDetail;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use Carbon\Carbon; // Import Carbon library for date manipulation


class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $today = Carbon::today();
        // Fetch the latest lotteries and tickets
        $lotteries = Lottery::whereDate('created_at', $today)->orderBy('draw_time', 'desc')->get();
        $winnersToday = TicketUserWinner::whereDate('created_at', $today)->orderBy('created_at', 'desc')->get();
        $ticketsToday = Ticket::whereDate('created_at', $today)->orderBy('created_at', 'desc')->get();
        $totaltickets = count(Ticket::orderBy('created_at', 'desc')->get());
        $user = User::whereDate('created_at', $today)->orderBy('created_at', 'desc')->get();
        $totaluser = count(User::orderBy('created_at', 'desc')->get());
        $allDashboardDetailsToday = Lottery::leftJoin('ticket_purchased_details', 'lotteries.id', '=', 'ticket_purchased_details.lottery_id')
        ->select('lotteries.id as lottery_id', 'ticket_purchased_details.name', 'ticket_purchased_details.amount', 'ticket_purchased_details.total_quantity')
        ->orderBy('lotteries.created_at', 'desc')
        ->get()
        ->groupBy('lottery_id')
        ->map(function ($items, $key) {
            return [
                'lottery_id' => $key,
                'names' => $items->pluck('name')->filter()->unique(),
                'total_amount' => $items->sum('amount'),
                'total_quantity' => $items->sum('total_quantity') // Sum of quantity for the same lottery_id
            ];
        });
    
        // Get the sum of amounts for tickets created today
        $totalAmountToday = TicketPurchasedDetail::whereDate('created_at', $today)->sum('amount')/100;
        $totalAmount = TicketPurchasedDetail::sum('amount')/100;

        $totalUsersToday = count($user);
        $totalTicketsCountToday = count($ticketsToday);
        $allDashboardDetailsTodayCountToday = count($allDashboardDetailsToday);
        $winnersCountToday = count($winnersToday);
        $lotteriesCountToday = count($lotteries);
        // Pass the data to the view
        return view('home', compact(
            'totaluser',
            'totaltickets',
            'totalAmount',
            'allDashboardDetailsToday',
            'totalTicketsCountToday',
            'totalUsersToday',
            'totalAmountToday',
            'ticketsToday',
            'allDashboardDetailsTodayCountToday',
            'winnersToday',
            'winnersCountToday',
            'lotteriesCountToday'
        ));
    }
}
