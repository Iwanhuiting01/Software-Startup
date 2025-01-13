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
