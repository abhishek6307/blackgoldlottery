<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lottery extends Model
{
    use HasFactory;
    protected $fillable = [
        'winning_number', 'drawn', 'draw_time', 'created_at', 'updated_at'
    ];
}
