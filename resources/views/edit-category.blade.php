@extends('layouts.app')

@section('content')
    <div class="container max-w-xl mx-auto py-6 mt-10">

        <div class="mb-5">
            <a href="{{ route('category.manage') }}" class="bg-blue-500 text-white px-4 py-2  rounded hover:bg-blue-600">
                <- Categorie beheer
            </a>
        </div>

        <h1 class="text-2xl font-bold mb-4">Categorie bewerken</h1>

        @if($errors->any())
            <div class="bg-red-100 text-red-700 p-3 rounded mb-4">
                {{ $errors->first() }}
            </div>
        @endif

        <form action="{{ route('category.update', $category->id) }}" method="POST">
            @csrf
            <div class="mb-4">
                <x-input-label for="name" :value="__('Naam')" />
                <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" value="{{ $category->name }}" required />
            </div>

            <div class="flex w-full justify-end">
                <x-primary-button class="w-full text-center flex justify-center">
                    {{ __('Categorie aanpassen') }}
                </x-primary-button>
            </div>
        </form>
    </div>
@endsection
