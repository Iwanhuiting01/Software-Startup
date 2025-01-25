@extends('layouts.app')

@section('content')
    <div class="container mx-auto py-6">
        <h1 class="text-2xl font-bold mb-6">Mijn Boeking Overzicht</h1>

        @if(session('success'))
            <div class="bg-green-100 text-green-700 p-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        @if($bookings->isEmpty())
            <p class="text-gray-600">Je hebt nog geen boekingen gedaan.</p>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 gap-6">
                @foreach ($bookings as $booking)
                    <div class="border rounded-lg shadow-lg overflow-hidden">
                        <!-- Vacation Image -->
                        <div class="h-48 bg-gray-100">
                            <img src="{{ asset($booking->vacation->image) }}" alt="{{ $booking->vacation->title }}" class="w-full h-full object-cover">
                        </div>

                        <div class="p-4">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <!-- Left Section: Vacation Details -->
                                <div class="flex flex-col justify-between h-full">
                                    <div>
                                        <a class="hover:text-gray-600" href="{{ route('vacation.show', ['id' => $booking->vacation->id]) }}">
                                            <h2 class="text-xl font-bold mb-2">{{ $booking->vacation->title }}</h2>
                                        </a>
                                        <p class="text-gray-700">

                                            <strong>Prijs:</strong> €{{ number_format($booking->vacation->price, 2, ',', '.') }}<br>
                                            <strong>Totaal aantal deelnemers:</strong> {{ $booking->vacation->currentParticipants() }}<br>
                                            <strong>Minimale groepsgrootte:</strong> {{ $booking->vacation->min_group_size }}<br>
                                            <strong>Maximale groepsgrootte:</strong> {{ $booking->vacation->max_group_size }}<br>
                                            <strong>Begin vakantie:</strong> {{ \Carbon\Carbon::parse($booking->vacation->start_date)->format('d-m-Y') }}<br>
                                            <strong>Einde vakantie:</strong> {{ \Carbon\Carbon::parse($booking->vacation->end_date)->format('d-m-Y') }}
                                        </p>
                                    </div>

                                    <p class="text-sm text-gray-500 mt-4">
                                        <strong>Boekingsdatum:</strong> {{ $booking->created_at->format('d-m-Y') }}
                                    </p>
                                </div>

                                <!-- Right Section: Person Details -->
                                <div class="flex flex-col justify-between h-full">
                                    <div>
                                        <h3 class="text-lg font-semibold mb-2">Persoonsgegevens</h3>
                                        <p class="text-gray-700">
                                            <strong>Naam:</strong> {{ $booking->first_name }}
                                            @if($booking->middle_name) {{ $booking->middle_name }} @endif
                                            {{ $booking->last_name }}<br>
                                            <strong>E-mail:</strong> {{ $booking->email }}<br>
                                            <strong>Geboortedatum:</strong> {{ \Carbon\Carbon::parse($booking->date_of_birth)->format('d-m-Y') }}
                                        </p>
                                    </div>

                                    <!-- Payment Information -->
                                    <div class="mt-4">
                                        <h3 class="text-lg font-semibold mb-2">Betalingsinformatie</h3>
                                        <p class="text-gray-700">
                                            <strong>Totaal Prijs:</strong> €{{ number_format($booking->price, 2, ',', '.') }}<br>
                                            <strong>Betaald:</strong> €{{ number_format($booking->amount_paid, 2, ',', '.') }}<br>
                                            <strong>Te Betalen:</strong>
                                            <span class="{{ $booking->price - $booking->amount_paid > 0 ? 'text-red-500' : 'text-green-500' }}">
                                                €{{ number_format($booking->price - $booking->amount_paid, 2, ',', '.') }}
                                            </span>
                                        </p>
                                    </div>

                                    <!-- Action Button -->
                                    <div class="mt-4">
                                        @if ($booking->amount_paid < $booking->price)
                                            <a href="{{ route('bookings.pay', $booking->id) }}"
                                               class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 block text-center">
                                                Betaal Resterend Bedrag
                                            </a>
                                        @else
                                            <span class="text-green-500 font-bold block text-center">Volledig Betaald</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
@endsection
