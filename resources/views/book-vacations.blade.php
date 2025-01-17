@extends('layouts.app')

@section('header')

    <header class="bg-white shadow">
        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
            <h1 class="text-3xl font-bold text-center text-gray-800">Boek een Groepsvakantie</h1>
        </div>
    </header>

@endsection

@section('content')

<div class="flex justify-center mt-8">
        <form method="GET" action="{{ route('vacations.index') }}" class="flex">
            <input
                type="text"
                name="search"
                placeholder="Zoek vakanties..."
                value="{{ $query ?? '' }}"
                class="border border-gray-300 rounded-l-md p-2 w-96 focus:ring focus:ring-blue-200"
            />
            <button
                type="submit"
                class="bg-blue-500 text-white px-4 py-2 rounded-r-md hover:bg-blue-600 focus:ring focus:ring-blue-300"
            >
                Zoeken
            </button>
        </form>
    </div>

    <div class="bg-gray-100 min-h-screen">
    <!-- Filter Form -->
    <div class="flex justify-center mt-8">
        <form method="GET" action="{{ route('vacations.index') }}" class="flex flex-col md:flex-row gap-4">

            <!-- Bestemming -->
            <select
                name="destination"
                class="border border-gray-300 rounded-md p-2 w-64 focus:ring focus:ring-blue-200"
            >
                <option value="">Kies een bestemming</option>
                <option value="Spanje" {{ request('destination') == 'Spanje' ? 'selected' : '' }}>Spanje</option>
                <option value="Oostenrijk" {{ request('destination') == 'Oostenrijk' ? 'selected' : '' }}>Oostenrijk</option>
                <option value="Rome" {{ request('destination') == 'Rome' ? 'selected' : '' }}>Rome</option>
            </select>

            <!-- Prijsrange -->
            <div class="flex gap-2">
                <input
                    type="number"
                    name="min_price"
                    placeholder="Min prijs"
                    value="{{ request('min_price') }}"
                    class="border border-gray-300 rounded-md p-2 w-28 focus:ring focus:ring-blue-200"
                />
                <input
                    type="number"
                    name="max_price"
                    placeholder="Max prijs"
                    value="{{ request('max_price') }}"
                    class="border border-gray-300 rounded-md p-2 w-28 focus:ring focus:ring-blue-200"
                />
            </div>

            <!-- Datumfilters -->
            <div class="flex gap-2">
                <input
                    type="date"
                    name="start_date"
                    value="{{ request('start_date') }}"
                    class="border border-gray-300 rounded-md p-2 w-36 focus:ring focus:ring-blue-200"
                />
                <input
                    type="date"
                    name="end_date"
                    value="{{ request('end_date') }}"
                    class="border border-gray-300 rounded-md p-2 w-36 focus:ring focus:ring-blue-200"
                />
            </div>

            <!-- Filterknop -->
            <button
                type="submit"
                class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600 focus:ring focus:ring-blue-300"
            >
                Filteren
            </button>
        </form>
    </div>


    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        @forelse($vacations as $vacation)
            <div class="bg-white shadow-md rounded-md overflow-hidden">
                <h3>{{ $vacation->name }}</h3>
            </div>
        @empty
            <p>Geen vakanties gevonden voor "{{ request('search') }}"</p>
        @endforelse
    </div>

    <div class="container mx-auto p-6 text-gray-800 max-w-screen-lg">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 max-w-screen-lg mx-auto">
            @foreach ($vacations as $vacation)
                <div class="border rounded-lg overflow-hidden shadow-sm flex flex-col h-full">
                    <!-- Afbeelding -->
                    <img src="{{ asset($vacation->image) }}" alt="{{ $vacation->title }}"
                         class="w-full h-48 object-cover">

                    <!-- Content -->
                    <div class="p-4 flex flex-col flex-grow">
                        <!-- Titel en beschrijving -->
                        <h2 class="text-xl font-semibold">{{ $vacation->title }}</h2>
                        <p class="text-gray-700 mb-2">{{ $vacation->description }}</p>

                        <!-- Groepsinformatie -->
                        <p class="text-sm text-gray-500">
                            Vereiste groepsgrootte: <strong>{{ $vacation->min_group_size }}</strong><br>
                            Aantal deelnemers: <strong>{{ $vacation->current_participants }}</strong>
                        </p>

                        <!-- Tags (categories) -->
                        @if($vacation->categories)
                        <div class="flex flex-wrap gap-2 mt-3">
                            @foreach ($vacation->categories as $category)
                                <span class="bg-blue-100 text-blue-700 text-sm px-3 py-1 rounded-full">
                                {{ $category->name }}
                            </span>
                            @endforeach
                        </div>
                        @endif

                        <!-- Spacer to push buttons to the bottom -->
                        <div class="flex-grow"></div>

                        <!-- Boek nu knop en prijs -->
                        <div class="flex items-center justify-between mt-4">
                            <a class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600" href="{{ route('vacation.show', ['id' => $vacation->id]) }}">
                                Lees meer
                            </a>
                            <span class="text-lg font-semibold text-gray-800">
                            €{{ $vacation->price }}
                        </span>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
