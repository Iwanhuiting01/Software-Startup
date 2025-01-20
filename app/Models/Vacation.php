<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vacation extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'long_description',
        'price',
        'start_date',
        'end_date',
        'max_group_size',
        'min_group_size',
        'current_participants',
        'image',
        'user_id',
    ];

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'category_vacation');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    public function remainingSlots()
    {
        // Calculate the remaining slots by subtracting current bookings from the max group size
        return $this->max_group_size - $this->bookings()->count();
    }

    public function currentParticipants()
    {
        // Count the total bookings for this vacation
        return $this->bookings()->count();
    }
}
