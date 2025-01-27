@extends('layouts.app')

@section('content')
    <div class="container mt-10 mx-auto py-6">
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-3xl font-bold">Beheer jouw vakanties</h1>
            <a href="{{ route('vacation.create') }}" class="bg-blue-500 text-white font-semibold px-4 py-2 rounded-lg shadow hover:bg-blue-600 transition">
                Nieuwe Vakantie
            </a>
        </div>
        @if(session('success'))
            <div class="bg-green-100 text-green-700 p-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        @if($vacations->isEmpty())
            <p class="text-gray-600">Je hebt nog geen vakanties aangemaakt.</p>
        @else
            <table class="table-auto w-full border-collapse border border-gray-300">
                <thead>
                <tr class="bg-gray-200 text-left">
                    <th class="border border-gray-300 px-4 py-2">Titel</th>
                    <th class="border border-gray-300 px-4 py-2">Omschrijving</th>
                    <th class="border border-gray-300 px-4 py-2">Prijs</th>
                    <th class="border border-gray-300 px-4 py-2">Groepsgrootte</th>
                    <th class="border border-gray-300 px-4 py-2">Deelnemers</th>
                    <th class="border border-gray-300 px-4 py-2">Beschikbare plaatsen</th>
                    <th class="border border-gray-300 px-4 py-2">Status</th>
                    <th class="border border-gray-300 px-4 py-2">Acties</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($vacations as $index => $vacation)
                    <tr class="{{ $index % 2 === 1 ? 'bg-gray-100' : 'bg-white' }}">
                        <td class="border border-gray-300 px-4 py-2">{{ $vacation->title }}</td>
                        <td class="border border-gray-300 px-4 py-2">{{ $vacation->description }}</td>
                        <td class="border border-gray-300 px-4 py-2">€{{ number_format($vacation->price, 2) }}</td>
                        <td class="border border-gray-300 px-4 py-2">
                            {{ $vacation->min_group_size }} - {{ $vacation->max_group_size }}
                        </td>
                        <td class="border border-gray-300 px-4 py-2">{{ $vacation->currentParticipants() }}</td>
                        <td class="border border-gray-300 px-4 py-2">{{ $vacation->remainingSlots() }}</td>
                        <td class="border border-gray-300 px-4 py-2">
                            {{ $vacation->is_closed ? 'Gesloten' : 'Open' }}
                        </td>
                        <td class="border border-gray-300 px-4 py-2 flex items-center">
                            <!-- Edit Button -->


                            <a href="{{ route('vacation.manage', $vacation->id) }}" class="mr-2">
                                <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512"><!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.-->
                                    <path d="M288 80c-65.2 0-118.8 29.6-159.9 67.7C89.6 183.5 63 226 49.4 256c13.6 30 40.2 72.5 78.6 108.3C169.2 402.4 222.8 432 288 432s118.8-29.6 159.9-67.7C486.4 328.5 513 286 526.6 256c-13.6-30-40.2-72.5-78.6-108.3C406.8 109.6 353.2 80 288 80zM95.4 112.6C142.5 68.8 207.2 32 288 32s145.5 36.8 192.6 80.6c46.8 43.5 78.1 95.4 93 131.1c3.3 7.9 3.3 16.7 0 24.6c-14.9 35.7-46.2 87.7-93 131.1C433.5 443.2 368.8 480 288 480s-145.5-36.8-192.6-80.6C48.6 356 17.3 304 2.5 268.3c-3.3-7.9-3.3-16.7 0-24.6C17.3 208 48.6 156 95.4 112.6zM288 336c44.2 0 80-35.8 80-80s-35.8-80-80-80c-.7 0-1.3 0-2 0c1.3 5.1 2 10.5 2 16c0 35.3-28.7 64-64 64c-5.5 0-10.9-.7-16-2c0 .7 0 1.3 0 2c0 44.2 35.8 80 80 80zm0-208a128 128 0 1 1 0 256 128 128 0 1 1 0-256z"/>
                                </svg>
                            </a>


                            <a href="{{ route('vacation.edit', ['id' => $vacation->id, 'overview' => true]) }}" class="mx-2">
                                <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                                    <path d="M441 58.9L453.1 71c9.4 9.4 9.4 24.6 0 33.9L424 134.1 377.9 88 407 58.9c9.4-9.4 24.6-9.4 33.9 0zM209.8 256.2L344 121.9 390.1 168 255.8 302.2c-2.9 2.9-6.5 5-10.4 6.1l-58.5 16.7 16.7-58.5c1.1-3.9 3.2-7.5 6.1-10.4zM373.1 25L175.8 222.2c-8.7 8.7-15 19.4-18.3 31.1l-28.6 100c-2.4 8.4-.1 17.4 6.1 23.6s15.2 8.5 23.6 6.1l100-28.6c11.8-3.4 22.5-9.7 31.1-18.3L487 138.9c28.1-28.1 28.1-73.7 0-101.8L474.9 25C446.8-3.1 401.2-3.1 373.1 25zM88 64C39.4 64 0 103.4 0 152L0 424c0 48.6 39.4 88 88 88l272 0c48.6 0 88-39.4 88-88l0-112c0-13.3-10.7-24-24-24s-24 10.7-24 24l0 112c0 22.1-17.9 40-40 40L88 464c-22.1 0-40-17.9-40-40l0-272c0-22.1 17.9-40 40-40l112 0c13.3 0 24-10.7 24-24s-10.7-24-24-24L88 64z"/>
                                </svg>
                            </a>


                            <!-- Close/Reopen Button -->
                            <form action="{{ $vacation->is_closed
                                ? route('vacation.reopen', ['id' => $vacation->id, 'overview' => true])
                                : route('vacation.close', ['id' => $vacation->id, 'overview' => true]) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <button type="submit">
                                    @if($vacation->is_closed)
                                        <svg class="w-6 mt-2 ml-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.--><path d="M438.6 105.4c12.5 12.5 12.5 32.8 0 45.3l-256 256c-12.5 12.5-32.8 12.5-45.3 0l-128-128c-12.5-12.5-12.5-32.8 0-45.3s32.8-12.5 45.3 0L160 338.7 393.4 105.4c12.5-12.5 32.8-12.5 45.3 0z"/></svg>
                                    @else
                                        <svg class="h-7 mt-2 ml-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.--><path d="M342.6 150.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L192 210.7 86.6 105.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3L146.7 256 41.4 361.4c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0L192 301.3 297.4 406.6c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L237.3 256 342.6 150.6z"/></svg>
                                    @endif
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        @endif
    </div>
@endsection
