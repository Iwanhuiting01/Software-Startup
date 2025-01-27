@extends('layouts.app')

@section('content')
    <div class="container mx-auto py-6 my-10">
        <div class="flex items-center justify-between mb-4">
            <h1 class="text-2xl font-bold">Categorieën Beheer</h1>
            <a href="{{ route('category.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                Categorie aanmaken
            </a>
        </div>

        @if(session('success'))
            <div class="bg-green-100 text-green-700 p-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="bg-red-100 text-red-700 p-3 rounded mb-4">
                {{ $errors->first() }}
            </div>
        @endif

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach ($categories as $category)
                <div class="border rounded-lg p-4 flex items-center hover:bg-gray-200 justify-between">
                    <span class="text-gray-800">{{ $category->name }}</span>
                    <div class="flex space-x-2">
                        <!-- Edit Button -->
                        <a href="{{ route('category.edit', $category->id) }}" class="text-blue-500 hover:text-blue-700">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.232 5.232l3.536 3.536M4 16v4h4l12-12-4-4L4 16z" />
                            </svg>
                        </a>

                        <!-- Delete Button -->
                        <button onclick="showDeleteModal({{ $category->id }}, '{{ $category->name }}')" class="text-red-500 hover:text-red-700">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Modal -->
    <div id="delete-modal" class="fixed inset-0 z-50 hidden bg-gray-800 bg-opacity-75 flex items-center justify-center">
        <div class="bg-white p-6 rounded-lg shadow-lg w-96">
            <h2 class="text-lg font-semibold mb-4">Categorie verwijderen</h2>
            <p class="mb-4" id="delete-modal-message">Weet je zeker dat je deze categorie wilt verwijderen?</p>
            <div class="flex justify-between space-x-4">
                <button onclick="hideDeleteModal()" class="bg-gray-300 px-4 py-2 rounded hover:bg-gray-400">
                    Annuleren
                </button>
                <form id="delete-form" method="POST" action="">
                    @csrf
                    <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600">
                        Verwijderen
                    </button>
                </form>
            </div>
        </div>
    </div>

    <script>
        function showDeleteModal(id, name) {
            const modal = document.getElementById('delete-modal');
            const message = document.getElementById('delete-modal-message');
            const form = document.getElementById('delete-form');

            message.textContent = `Weet je zeker dat je de categorie "${name}" wilt verwijderen?`;
            form.action = `/category/delete/${id}`;
            modal.classList.remove('hidden');
        }

        function hideDeleteModal() {
            const modal = document.getElementById('delete-modal');
            modal.classList.add('hidden');
        }
    </script>
@endsection
