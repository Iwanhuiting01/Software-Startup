@extends('layouts.app')

@section('content')
    <div class="container mt-10 mx-auto py-6">
        @if(session('success'))
            <div class="bg-green-100 text-green-700 p-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold">Beheer vakantie: {{ $vacation->title }}</h1>
            <div class="flex gap-4">
                <!-- Back to vacation management -->
                <a href="{{ route('vacations.manage') }}" class="bg-gray-500 text-white px-4 py-2 rounded-md hover:bg-gray-600">
                    Terug naar overzicht
                </a>

                <!-- Edit Vacation Button -->
                <a href="{{ route('vacation.edit', ['id' => $vacation->id]) }}" class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600">
                    Bewerken
                </a>

                <!-- Open/Close Vacation Button -->
                <form action="{{ $vacation->is_closed
                                    ? route('vacation.reopen', ['id' => $vacation->id, 'overview' => false])
                                    : route('vacation.close', ['id' => $vacation->id, 'overview' => false]) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <button type="submit" class="{{ $vacation->is_closed ? 'bg-green-500' : 'bg-red-500' }} text-white px-4 py-2 rounded-md hover:opacity-90">
                        {{ $vacation->is_closed ? 'Openen' : 'Sluiten' }}
                    </button>
                </form>
            </div>
        </div>

        <!-- Vacation Details -->
        <div class="bg-white shadow-md rounded-lg p-6 mb-8">
            <h2 class="text-xl font-semibold mb-4">Vakantie Details</h2>
            <p><strong>Status:</strong>
                <span class="{{ $vacation->is_closed ? 'text-red-500' : 'text-green-500' }}">
                    {{ $vacation->is_closed ? 'Gesloten' : 'Open' }}
                </span>
            </p>
            <p><strong>Korte beschrijving:</strong> {{ $vacation->description }}</p>
            <p><strong>Gedetailleerde beschrijving:</strong> {{ $vacation->long_description }}</p>
            <p><strong>Prijs:</strong> €{{ number_format($vacation->price, 2) }}</p>
            <p><strong>Groepsgrootte:</strong> {{ $vacation->min_group_size }} - {{ $vacation->max_group_size }}</p>
            <p><strong>Startdatum:</strong> {{ $vacation->start_date }}</p>
            <p><strong>Einddatum:</strong> {{ $vacation->end_date }}</p>
            <p><strong>Beschikbare plaatsen:</strong> {{ $vacation->remainingSlots() }}</p>
            <p><strong>Categorieën:</strong>
                @foreach($vacation->categories as $category)
                    <span class="inline-block bg-blue-100 text-blue-800 text-sm px-3 py-1 rounded-full mr-2">{{ $category->name }}</span>
                @endforeach
            </p>
        </div>

        <!-- Booking Details -->
        <div class="bg-white shadow-md rounded-lg p-6">
            <h2 class="text-xl font-semibold mb-4">Boekingen</h2>

            @if($vacation->bookings->isEmpty())
                <p class="text-gray-600">Er zijn nog geen boekingen voor deze vakantie.</p>
            @else
                <table class="table-auto w-full border-collapse border border-gray-300">
                    <thead>
                        <tr class="bg-gray-200">
                            <th class="border border-gray-300 px-4 py-2">Naam</th>
                            <th class="border border-gray-300 px-4 py-2">Email</th>
                            <th class="border border-gray-300 px-4 py-2">Geboortedatum</th>
                            <th class="border border-gray-300 px-4 py-2">Betaald Bedrag</th>
                            <th class="border border-gray-300 px-4 py-2">Totale Prijs</th>
                            <th class="border border-gray-300 px-4 py-2">Betaalstatus</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($vacation->bookings as $booking)
                            <tr class="{{ $loop->index % 2 === 0 ? 'bg-gray-100' : 'bg-white' }}">
                                <td class="border border-gray-300 px-4 py-2">
                                    {{ $booking->first_name }} {{ $booking->middle_name }} {{ $booking->last_name }}
                                </td>
                                <td class="border border-gray-300 px-4 py-2">{{ $booking->email }}</td>
                                <td class="border border-gray-300 px-4 py-2">{{ $booking->date_of_birth }}</td>
                                <td class="border border-gray-300 px-4 py-2">€{{ number_format($booking->amount_paid, 2) }}</td>
                                <td class="border border-gray-300 px-4 py-2">€{{ number_format($booking->price, 2) }}</td>
                                <td class="border border-gray-300 px-4 py-2">
                                    @if($booking->amount_paid >= $booking->price)
                                        <span class="text-green-500 font-semibold">Volledig betaald</span>
                                    @else
                                        <span class="text-red-500 font-semibold">Nog te betalen</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>
@endsection
