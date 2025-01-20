@extends('layouts.app')

@section('content')
    <div class="container mx-auto py-6 text-center">
        <h1 class="text-2xl font-bold mb-6">Betaling voor {{ $booking->vacation->title }}</h1>
        <p class="text-lg mb-4">Te betalen bedrag: €{{ number_format($booking->price - $booking->amount_paid, 2, ',', '.') }}</p>
        <form action="{{ route('bookings.confirm-payment', $booking->id) }}" method="POST">
            @csrf
            <button type="submit" class="bg-green-500 text-white px-6 py-3 rounded-lg hover:bg-green-600">
                Bevestig Betaling
            </button>
        </form>
    </div>
@endsection
