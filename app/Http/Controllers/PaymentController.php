<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Razorpay\Api\Api;
use Illuminate\Support\Facades\Auth;
use App\Models\Ticket;
use App\Models\Lottery;
use App\Models\TicketPurchasedDetail;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class PaymentController extends Controller
{
    public function initiatePayment(Request $request)
    {
        $validatedData = $request->validate([
            'number' => 'required|integer|min:1|max:5',
        ]);

        $user = Auth::user();
        $amount = $validatedData['number'] * 11 * 100; // Amount in paise (assuming each ticket costs 10 units)

        $api = new Api(env('RAZORPAY_KEY'), env('RAZORPAY_SECRET'));
        $order = $api->order->create([
            'receipt' => uniqid(),
            'amount' => $amount,
            'currency' => 'INR',
            'payment_capture' => 1,
            'notes' => [
                'totalQuantity' => $validatedData['number'],
                'name' => $user->name,
                'email' => $user->email,
                'user_id' => $user->id,
                'role' => $user->role,
                'type' => $user->type
            ]
        ]);

        $orderId = $order['id'];

        return view('payment', compact('orderId', 'amount'));
    }

    public function paymentCallback(Request $request)
    {
        $input = $request->all();
        $api = new Api(env('RAZORPAY_KEY'), env('RAZORPAY_SECRET'));

        $payment = $api->payment->fetch($input['razorpay_payment_id']);

        // Fetch the order details using the order_id from the payment
        $order = $api->order->fetch($payment->order_id);

        // Combine payment and order details for debugging
        $details = [
            'payment' => $payment->toArray(),
            'order' => $order->toArray(),
        ];

        if ($payment->status == 'captured') {
            try {
                // Save the payment and order details to the database
                $ticketDetail = new TicketPurchasedDetail();
                $ticketDetail->payment_id = $details['payment']['id'];
                $ticketDetail->order_id = $details['order']['id'];
                $ticketDetail->receipt = $details['order']['receipt'];
                $ticketDetail->amount = $details['payment']['amount'];
                $ticketDetail->currency = $details['payment']['currency'];
                $ticketDetail->status = $details['payment']['status'];
                $ticketDetail->method = $details['payment']['method'];
                $ticketDetail->vpa = $details['payment']['vpa'] ?? null;
                $ticketDetail->email = $details['payment']['email'];
                $ticketDetail->contact = $details['payment']['contact'];
                $ticketDetail->fee = $details['payment']['fee'] ?? null;
                $ticketDetail->tax = $details['payment']['tax'] ?? null;
                $ticketDetail->description = $details['payment']['description'] ?? null;
                $ticketDetail->user_id = $details['payment']['notes']['user_id'];
                $ticketDetail->name = $details['payment']['notes']['name'];
                $ticketDetail->role = $details['payment']['notes']['role'];
                $ticketDetail->type = $details['payment']['notes']['type'];
                $ticketDetail->total_quantity = $details['payment']['notes']['totalQuantity'];
                $ticketDetail->save();

                $request->number = $details['order']['notes']['totalQuantity'];

                $undrawnLottery = Lottery::where('drawn', false)->first();
                $undrawnLotteryId = $undrawnLottery->id;

                $current_time = Carbon::now();
                $minute = $current_time->minute;

                $ticket = new Ticket();
                $ticket->number = str_pad($request->number, 2, '0', STR_PAD_LEFT);
                $ticketNumber = str_pad($request->number, 2, '0', STR_PAD_LEFT);
                $ticket->lottery_id = $undrawnLotteryId;
                $ticket->user_id = $details['payment']['notes']['user_id'];

                $result = $this->generateWinningNumbers($ticket);

                if ($result['status'] === 'full') {
                    return response()->json(['error' => 'All Tickets are Saled ! Look for new one.'], 403);
                }

                $ticket->win_num1 = $result['winningNumbers'][0] ?? null;
                $ticket->win_num2 = $result['winningNumbers'][1] ?? null;
                $ticket->win_num3 = $result['winningNumbers'][2] ?? null;
                $ticket->win_num4 = $result['winningNumbers'][3] ?? null;
                $ticket->win_num5 = $result['winningNumbers'][4] ?? null;
                $ticket->save();

            } catch (\Exception $e) {
                Log::error('Ticket purchase error: ' . $e->getMessage());
                return response()->json(['error' => 'An error occurred during ticket purchase.'.$e], 500);
            }
            return redirect('/profile');
        } else {
            return redirect('/');
        }
    }

    private function generateWinningNumbers(Ticket $ticket)
    {
        $lotteryId = $ticket->lottery_id;
        $count = intval($ticket->number);
        $winningNumbers = [];

        // Assuming we need a unique set of 5 numbers for each ticket
        while (count($winningNumbers) < $count) {
            $number = mt_rand(1, 99);

            if (!in_array($number, $winningNumbers)) {
                $winningNumbers[] = $number;
            }
        }

        return ['status' => 'success', 'winningNumbers' => $winningNumbers];
    }
}
