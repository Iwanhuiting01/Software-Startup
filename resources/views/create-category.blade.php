@extends('layouts.app')

@section('content')
    <div class="container max-w-xl mx-auto py-6 mt-10">

        <div class="mb-5">
            <a href="{{ route('category.manage') }}" class="bg-blue-500 text-white px-4 py-2  rounded hover:bg-blue-600">
                <- Categorie beheer
            </a>
        </div>

        <h1 class="text-2xl font-bold mb-4">Nieuwe categorie toevoegen</h1>


        <form action="{{ route('category.store') }}" method="POST">
        @csrf

        <!-- Category Name -->
            <div class="mb-4">
                <x-input-label for="name" :value="__('Category Name')" />
                <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required />
                <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div>

            <!-- Submit Button -->
            <div class="flex w-full justify-end">
                <x-primary-button class="w-full text-center flex justify-center">
                    {{ __('Save Category') }}
                </x-primary-button>
            </div>
        </form>
    </div>
@endsection
