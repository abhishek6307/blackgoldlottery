<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TicketUserWinner extends Model
{
    use HasFactory;
    protected $fillable = [
        'ticket_id', 'user_id', 'lottery_id', 'winner_number', 'winner_name', 'winning_amount'
    ];
}
