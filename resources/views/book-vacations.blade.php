@extends('layouts.app')

@section('header')



    <header class="bg-white shadow">
        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
            <h1 class="text-3xl font-bold text-center text-gray-800">Boek een Groepsvakantie</h1>
        </div>
    </header>

@endsection

@section('content')
<div class="container mx-auto p-6 text-gray-800 max-w-screen-lg">


    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 max-w-screen-lg mx-auto">
        @foreach ($vacations as $vacation)
            <div class="border rounded-lg overflow-hidden shadow-sm">
                <!-- Afbeelding -->
                <img src="{{ asset($vacation->image) }}" alt="{{ $vacation->title }}"
                     class="w-full h-48 object-cover">

                <!-- Titel en beschrijving -->
                <div class="p-4">
                    <h2 class="text-xl font-semibold">{{ $vacation->title }}</h2>
                    <p class="text-gray-700 mb-2">{{ $vacation->description }}</p>

                    <!-- Groepsinformatie -->
                    <p class="text-sm text-gray-500">
                        Vereiste groepsgrootte: <strong>{{ $vacation->group_size }}</strong><br>
                        Aantal deelnemers: <strong>{{ $vacation->current_participants }}</strong>
                    </p>

                    <!-- Boek nu knop -->
                    <button class="bg-blue-500 text-white px-4 py-2 mt-4 rounded hover:bg-blue-600">
                        Boek Nu
                    </button>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection
