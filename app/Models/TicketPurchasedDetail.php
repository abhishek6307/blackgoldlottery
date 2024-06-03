<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TicketPurchasedDetail extends Model
{
    use HasFactory;
    protected $fillable = [
        'payment_id',
        'order_id',
        'receipt',
        'amount',
        'currency',
        'status',
        'method',
        'vpa',
        'email',
        'contact',
        'fee',
        'tax',
        'description',
        'user_id',
        'name',
        'role',
        'type',
        'total_quantity',
    ];
}
