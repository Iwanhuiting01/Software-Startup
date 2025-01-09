@extends('layouts.app')

@section('content')
    <div class="container mx-auto p-6">
        <h1 class="text-3xl font-bold text-center mb-6">Boek een Groepsvakantie</h1>
        <p class="text-center mb-8 text-gray-600">
            Vind jouw perfecte groepsvakantie! Goedkoper reizen door samen te gaan met anderen.
        </p>


        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <!-- Placeholder vakanties -->
            @foreach ($vacations as $vacation)
            <div class="border rounded-lg p-4 shadow-sm">
                <h2 class="text-xl font-semibold">{{ $vacation['title'] }}</h2>
                <p class="text-gray-700 mb-2">{{ $vacation['description'] }}</p>
                <p class="text-sm text-gray-500">
                    Vereiste groepsgrootte: <strong>{{ $vacation['group_size'] }}</strong><br>
                    Aantal deelnemers: <strong>{{ $vacation['current_participants'] }}</strong>
                </p>
                <button class="bg-blue-500 text-white px-4 py-2 mt-4 rounded hover:bg-blue-600">
                    Boek Nu
                </button>
            </div>
            @endforeach
        </div>
    </div>
@endsection