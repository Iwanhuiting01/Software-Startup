<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Vacation;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function create(Vacation $vacation)
    {
        return view('bookings.create', compact('vacation'));
    }

    public function store(Request $request, Vacation $vacation)
    {
        $data = $request->validate([
            'guests' => 'required|array|min:1', // Ensure at least one guest
            'guests.*.first_name' => 'required|string|max:255',
            'guests.*.middle_name' => 'nullable|string|max:255',
            'guests.*.last_name' => 'required|string|max:255',
            'guests.*.date_of_birth' => 'required|date',
            'guests.*.email' => 'required|email',
            'payment_type' => 'required|in:downpayment,fullpayment',
        ]);

        $requestedGuests = count($data['guests']);
        $remainingSlots = $vacation->remainingSlots();

        if ($requestedGuests > $remainingSlots) {
            return redirect()
                ->back()
                ->withErrors(['message' => 'Er zijn onvoldoende beschikbare plaatsen voor deze vakantie.'])
                ->withInput();
        }

        // Create bookings for each guest
        foreach ($data['guests'] as $guest) {
            Booking::create([
                'user_id' => auth()->id(),
                'vacation_id' => $vacation->id,
                'first_name' => $guest['first_name'],
                'middle_name' => $guest['middle_name'],
                'last_name' => $guest['last_name'],
                'date_of_birth' => $guest['date_of_birth'],
                'email' => $guest['email'],
                'price' => $vacation->price,
                'amount_paid' => $data['payment_type'] === 'downpayment' ? $vacation->price * 0.2 : $vacation->price, // 20% for downpayment
            ]);
        }

        // Redirect to payment confirmation page
        return redirect()->route('bookings.manage')->with('success', 'Boeking succesvol voltooid!');
    }

    public function manage()
    {
        // Fetch current user's bookings with associated vacation details
        $bookings = Booking::with('vacation')
            ->where('user_id', auth()->id())
            ->orderByDesc('created_at')
            ->get();

        return view('bookings.manage', compact('bookings'));
    }

    public function pay(Booking $booking)
    {
        return view('bookings.pay', compact('booking'));
    }

    public function confirmPayment(Request $request, Booking $booking)
    {
        $booking->update([
            'amount_paid' => $booking->price, // Mark as fully paid
        ]);

        return redirect()->route('bookings.manage')->with('success', 'Betaling voltooid!');
    }
}
