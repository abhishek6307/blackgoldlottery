<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WinningNumber extends Model
{
    use HasFactory;
    protected $fillable = ['lottery_id', 'number'];

    public function ticket()
{
    return $this->belongsTo(Ticket::class, 'lottery_id', 'lottery_id')->where('user_id', $this->user_id);
}

}
