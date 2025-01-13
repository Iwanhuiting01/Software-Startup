@extends('layouts.app')

@section('content')
    <div class="container max-w-2xl mx-auto py-6">
        <h1 class="text-2xl font-bold mb-4">Nieuwe vakantie toevoegen</h1>

        <form action="{{ route('vacation.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <!-- Title -->
            <div class="mb-4">
                <x-input-label for="title" :value="__('Title')" />
                <x-text-input id="title" class="block mt-1 w-full" type="text" name="title" :value="old('title')" required />
                <x-input-error :messages="$errors->get('title')" class="mt-2" />
            </div>

            <!-- Description -->
            <div class="mb-4">
                <x-input-label for="description" :value="__('Short Description')" />
                <textarea name="description" id="description" rows="4" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm" required>{{ old('description') }}</textarea>
                <x-input-error :messages="$errors->get('description')" class="mt-2" />
            </div>

            <!-- Long Description -->
            <div class="mb-4">
                <x-input-label for="long_description" :value="__('Detailed Description')" />
                <textarea name="long_description" id="long_description" rows="6" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm">{{ old('long_description') }}</textarea>
                <x-input-error :messages="$errors->get('long_description')" class="mt-2" />
            </div>

            <!-- Categories -->
            <div class="mb-4">
                <x-input-label :value="__('Categories')" />
                <div class="flex flex-wrap gap-4 mt-2">
                    @foreach ($categories as $category)
                        <label class="flex items-center space-x-2">
                            <input type="checkbox" name="categories[]" value="{{ $category->id }}" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500">
                            <span>{{ $category->name }}</span>
                        </label>
                    @endforeach
                </div>
                <x-input-error :messages="$errors->get('categories')" class="mt-2" />
            </div>

            <!-- Group Size -->
            <div class="grid grid-cols-2 gap-4 mb-4">
                <div>
                    <x-input-label for="min_group_size" :value="__('Minimum Group Size')" />
                    <x-text-input id="min_group_size" class="block mt-1 w-full" type="number" name="min_group_size" :value="old('min_group_size')" required />
                    <x-input-error :messages="$errors->get('min_group_size')" class="mt-2" />
                </div>
                <div>
                    <x-input-label for="max_group_size" :value="__('Maximum Group Size')" />
                    <x-text-input id="max_group_size" class="block mt-1 w-full" type="number" name="max_group_size" :value="old('max_group_size')" required />
                    <x-input-error :messages="$errors->get('max_group_size')" class="mt-2" />
                </div>
            </div>

            <!-- Price -->
            <div class="mb-4">
                <x-input-label for="price" :value="__('Price (€)')" />
                <x-text-input id="price" class="block mt-1 w-full" type="number" step="0.01" name="price" :value="old('price')" required />
                <x-input-error :messages="$errors->get('price')" class="mt-2" />
            </div>

            <!-- Start and End Dates -->
            <div class="grid grid-cols-2 gap-4 mb-4">
                <div>
                    <x-input-label for="start_date" :value="__('Start Date')" />
                    <x-text-input id="start_date" class="block mt-1 w-full" type="date" name="start_date" :value="old('start_date')" required />
                    <x-input-error :messages="$errors->get('start_date')" class="mt-2" />
                </div>
                <div>
                    <x-input-label for="end_date" :value="__('End Date')" />
                    <x-text-input id="end_date" class="block mt-1 w-full" type="date" name="end_date" :value="old('end_date')" required />
                    <x-input-error :messages="$errors->get('end_date')" class="mt-2" />
                </div>
            </div>

            <!-- Upload Image -->
            <div class="mb-4">
                <x-input-label for="image" :value="__('Upload Image')" />
                <label for="image" class="mt-1 block w-full cursor-pointer rounded-md bg-blue-600 text-white text-center py-2 shadow-sm hover:bg-blue-700">
                    {{ __('Choose File') }}
                </label>
                <input id="image" type="file" name="image" class="hidden" />
                <x-input-error :messages="$errors->get('image')" class="mt-2" />
            </div>

            <!-- Submit Button -->
            <div class="flex w-full justify-end">
                <x-primary-button class="w-full text-center flex justify-center">
                    {{ __('Save Vacation') }}
                </x-primary-button>
            </div>
        </form>
    </div>
@endsection
