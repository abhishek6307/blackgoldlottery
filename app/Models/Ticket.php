<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;
    protected $fillable = [
        'number', 'lottery_id', 'user_id', 'win_num1', 'win_num2', 'win_num3', 'win_num4', 'win_num5'
    ];
    public function lottery()
    {
        return $this->belongsTo(Lottery::class);
    }

    public function winningNumbers()
{
    return $this->hasMany(WinningNumber::class, 'lottery_id', 'lottery_id')->where('user_id', $this->user_id);
}
}
