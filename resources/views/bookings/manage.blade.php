@extends('layouts.app')

@section('content')
    <div class="container mx-auto py-6">
        <h1 class="text-2xl font-bold mb-6">Mijn Boekingen Overzicht</h1>

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
                    <div class="h-full border rounded-lg shadow-lg flex flex-col">
                        <!-- Vacation Image -->
                        <div class="h-48 bg-gray-100">
                            <img src="{{ asset($booking->vacation->image) }}" alt="{{ $booking->vacation->title }}" class="w-full h-full object-cover">
                        </div>

                        <!-- Content Section: Two Columns -->
                        <div class="p-4 flex flex-col flex-grow">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 h-full">
                                <!-- Left Column: Vacation Details -->
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

                                <!-- Right Column: Person Details & Action -->
                                <div class="flex flex-col justify-between">
                                    <!-- Personal Details -->
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
                                            @if (!$booking->is_cancelled)
                                                <strong>Te Betalen:</strong>
                                                <span class="{{ $booking->price - $booking->amount_paid > 0 ? 'text-red-500' : 'text-green-500' }}">
                                                    €{{ number_format($booking->price - $booking->amount_paid, 2, ',', '.') }}
                                                </span>
                                            @else
                                                <strong>Restitutie Bedrag:</strong>
                                                <span class="text-blue-500">
                                                    €{{ number_format($booking->amount_paid, 2, ',', '.') }}
                                                </span>
                                            @endif
                                        </p>
                                    </div>

                                    <!-- Booking Status -->
                                    <div class="mt-4">
                                        @if ($booking->is_cancelled)
                                            <span class="text-red-500 font-bold block">Geannuleerd</span>
                                            <p class="text-gray-700 text-sm mt-2">
                                                Deze boeking is geannuleerd. Het betaalde bedrag van
                                                €{{ number_format($booking->amount_paid, 2, ',', '.') }} wordt teruggestort.
                                            </p>
                                        @else
                                            @if ($booking->amount_paid < $booking->price)
                                                <a href="{{ route('bookings.pay', $booking->id) }}"
                                                   class="bg-blue-500 text-white px-4 py-3 rounded hover:bg-blue-600">
                                                    Betaal Resterend Bedrag
                                                </a>
                                            @else
                                                <span class="text-green-500 font-bold block">Volledig Betaald</span>
                                            @endif
                                        @endif
                                    </div>

                                    <!-- Action Button -->
                                    @if(!$booking->is_cancelled)
                                    <div class="mt-4">
                                        <button onclick="showCancelModal(
                                            {{ $booking->id }}, '{{ $booking->vacation->title }}', '{{$booking->amount_paid}}')"
                                                class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600 block text-center"
                                        >
                                            Annuleer Boeking
                                        </button>
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

    <!-- Cancel Modal -->
    <div id="cancel-modal" class="fixed inset-0 z-50 hidden bg-gray-800 bg-opacity-75 flex items-center justify-center">
        <div class="bg-white p-6 rounded-lg shadow-lg w-96">
            <h2 class="text-lg font-semibold mb-4">Boeking annuleren</h2>
            <p class="mb-4" id="cancel-modal-message">Weet je zeker dat je deze boeking wilt annuleren?</p>
            <div class="flex justify-between space-x-4">
                <button onclick="hideCancelModal()" class="bg-gray-300 px-4 py-2 rounded hover:bg-gray-400">
                    Annuleren
                </button>
                <form id="cancel-form" method="POST" action="">
                    @csrf
                    @method('PUT')
                    <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600">
                        Bevestig Annulering
                    </button>
                </form>
            </div>
        </div>
    </div>

    <script>
        function showCancelModal(id, vacationTitle, amountPaid) {
            const modal = document.getElementById('cancel-modal');
            const message = document.getElementById('cancel-modal-message');
            const form = document.getElementById('cancel-form');

            message.textContent = `Weet je zeker dat je de boeking voor "${vacationTitle}" wilt annuleren?
            De volledige som van €${amountPaid} zal teruggestort worden op het bank-account waar de boeking mee betaald was.`;
            form.action = `/bookings/${id}/cancel`; // Update action dynamically
            modal.classList.remove('hidden');
        }

        function hideCancelModal() {
            const modal = document.getElementById('cancel-modal');
            modal.classList.add('hidden');
        }
    </script>
@endsection
