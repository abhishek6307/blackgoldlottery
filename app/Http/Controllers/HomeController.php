<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Lottery;
use App\Models\Ticket;

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
        // Fetch the latest lotteries and tickets
        $lotteries = Lottery::orderBy('draw_time', 'desc')->get();
        $tickets = Ticket::orderBy('created_at', 'desc')->get();
        $alldashboardDetails = Ticket::orderBy('created_at', 'desc')->get();

        // Pass the data to the view
        return view('home', compact('lotteries', 'tickets', 'alldashboardDetails'));
    }
}
