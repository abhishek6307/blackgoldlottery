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


}
