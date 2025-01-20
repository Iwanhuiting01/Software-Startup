@extends('layouts.app')

@section('content')
    <div class="container mt-10 mx-auto py-6">
        <div class="max-w-4xl mx-auto bg-white shadow-lg rounded-lg overflow-hidden">
            <!-- Vacation Image -->
            <img src="{{ asset($vacation->image) }}" alt="{{ $vacation->title }}" class="w-full h-64 object-cover">

            <!-- Vacation Details -->
            <div class="p-6">
                <h1 class="text-3xl font-bold mb-4">{{ $vacation->title }}</h1>

                <!-- Short Description -->
                <p class="text-gray-700 mb-4">{{ $vacation->description }}</p>

                <!-- Detailed Description -->
                @if ($vacation->long_description)
                    <h2 class="text-lg font-semibold mb-2">Details</h2>
                    <p class="text-gray-600 mb-4">{{ $vacation->long_description }}</p>
                @endif

            <!-- Group Information -->
                <div class="mb-4">
                    <p class="text-sm text-gray-500">
                        <strong>Minimum Groepsgrootte:</strong> {{ $vacation->min_group_size }}<br>
                        <strong>Maximum Groepsgrootte:</strong> {{ $vacation->max_group_size }}<br>
                        <strong>Deelnemers:</strong> {{ $vacation->currentParticipants() }}
                    </p>
                </div>

                <!-- Date and Price -->
                <div class="mb-4">
                    <p class="text-sm text-gray-500">
                        <strong>Startdatum:</strong> {{ \Carbon\Carbon::parse($vacation->start_date)->format('d-m-Y') }}<br>
                        <strong>Einddatum:</strong> {{ \Carbon\Carbon::parse($vacation->end_date)->format('d-m-Y') }}<br>
                        <strong>Prijs:</strong> €{{ number_format($vacation->price, 2, ',', '.') }}
                    </p>
                </div>

                <!-- Categories -->
                @if ($vacation->categories->isNotEmpty())
                    <div class="mb-4">
                        <h2 class="text-lg font-semibold mb-2">Categorieën</h2>
                        <div class="flex flex-wrap gap-2">
                            @foreach ($vacation->categories as $category)
                                <span class="bg-blue-100 text-blue-700 text-sm px-3 py-1 rounded-full">
                                    {{ $category->name }}
                                </span>
                            @endforeach
                        </div>
                    </div>
            @endif

            <!-- Actions -->
                <div class="flex justify-between mt-6">
                    <a href="{{ route('vacations.index') }}" class="bg-gray-300 text-gray-800 px-4 py-2 rounded hover:bg-gray-400">
                        Vakantie overzicht
                    </a>
                    <a href="{{ route('bookings.create', $vacation->id) }}" class="bg-blue-500 text-white px-4 py-2 ml-4 rounded hover:bg-blue-600">
                        Boek Nu
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
