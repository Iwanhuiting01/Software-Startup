<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'vacation_id',
        'first_name',
        'middle_name',
        'last_name',
        'date_of_birth',
        'email',
        'price',
        'amount_paid',
        'is_cancelled',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function vacation()
    {
        return $this->belongsTo(Vacation::class);
    }
}
