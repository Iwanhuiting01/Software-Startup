@extends('layouts.app')

@section('content')
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden sm:rounded-lg shadow-lg col-md-2 col-2">
                <div class="p-6 text-gray-900">
                    <div class="container mx-auto p-6 max-w-screen-lg">
                        <!-- Page Title -->
                        <h1 class="text-3xl font-bold text-center mb-6">Welkom bij Dealtrip</h1>

                        <!-- Featured Vacations Carousel -->
                        <div class="relative">
                            <div class="carousel overflow-hidden relative" style="height: 25rem;">
                                <!-- Carousel Items -->
                                <div class="carousel-track flex transition-transform duration-500" style="transform: translateX(0);">
                                    @foreach ($featuredVacations as $vacation)
                                        <div class="carousel-item min-w-full flex-shrink-0 p-4">
                                            <div class="border rounded-lg shadow-lg overflow-hidden">
                                                <!-- Vacation Image -->
                                                <img src="{{ asset($vacation->image) }}" alt="{{ $vacation->title }}" class="w-full h-48 object-cover">
                                                <!-- Vacation Details -->
                                                <div class="p-4">
                                                    <h2 class="text-xl font-semibold mb-2">{{ $vacation->title }}</h2>
                                                    <p class="text-gray-600 text-sm mb-4">{{ Str::limit($vacation->description, 100) }}</p>
                                                    <div class="flex justify-between items-center">
                                                        <span class="text-lg font-bold text-gray-800">€{{ number_format($vacation->price, 2, ',', '.') }}</span>
                                                        <a href="{{ route('vacation.show', $vacation->id) }}" class="text-blue-500 hover:underline">
                                                            Meer bekijken
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            <!-- Navigation Buttons -->
                            <button onclick="prevSlide(true)" class="absolute top-1/2 left-4 transform -translate-y-1/2 bg-gray-700 text-white rounded-full w-10 h-10 flex items-center justify-center hover:bg-gray-900">
                                &#10094;
                            </button>
                            <button onclick="nextSlide(true)" class="absolute top-1/2 right-4 transform -translate-y-1/2 bg-gray-700 text-white rounded-full w-10 h-10 flex items-center justify-center hover:bg-gray-900">
                                &#10095;
                            </button>
                        </div>

                        <!-- Website Description -->
                        <div class="bg-gray-100 p-6 rounded-lg shadow-md text-center my-8">
                            <h2 class="text-2xl font-bold mb-4">Over Dealtrip</h2>
                            <p class="text-gray-700">
                                Dealtrip is de perfecte plek om jouw volgende groepsvakantie te plannen!
                                Ontdek een breed aanbod van vakanties voor elk type reiziger, met unieke bestemmingen,
                                geweldige prijzen, en een gebruiksvriendelijke ervaring. Vind je perfecte reis vandaag nog!
                            </p>
                        </div>

                        <div class="bg-gray-100 p-6 rounded-lg shadow-md text-center my-8">
                            <h2 class="text-2xl font-bold mb-4">Onze missie</h2>
                            <p class="text-gray-700">
                                Bij Dealtrip is het onze missie om iedereen een goede vakantie aan te kunnen bieden.
                                Voor ons is het belangrijk dat iedereen op vakantie kan, zonder zich zorgen te hoeven maken over hun budget.
                                Wij vinden dat iedereen moet kunnen genieten van een leuke vakantie, wie ze ook zijn.
                                Daarom streven wij ernaar om diverse vakanties aan te bieden, om voor iedereen een reis te hebben.
                            </p>
                        </div>

                        <!-- See All Vacations Button -->
                        <div class="flex justify-center">
                            <a href="{{ route('vacations.index') }}" class="bg-blue-500 text-white px-6 py-3 rounded-lg hover:bg-blue-600 transition">
                                Bekijk alle vakanties
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Carousel Script -->
    <script>
        let currentSlide = 0;
        let autoScroll = true;

        const autoScrollInterval = setInterval(() => {
            if (autoScroll) {
                nextSlide();
            }
        }, 5000);

        function updateCarousel() {
            const track = document.querySelector('.carousel-track');
            const slides = document.querySelectorAll('.carousel-item');
            const totalSlides = slides.length;

            // Ensure currentSlide is within bounds
            if (currentSlide < 0) currentSlide = totalSlides - 1;
            if (currentSlide >= totalSlides) currentSlide = 0;

            // Update transform property
            const offset = -currentSlide * 100;
            track.style.transform = `translateX(${offset}%)`;
        }

        function nextSlide(userInteraction = false) {
            if (userInteraction) stopAutoScroll();
            currentSlide++;
            updateCarousel();
        }

        function prevSlide(userInteraction = false) {
            if (userInteraction) stopAutoScroll();
            currentSlide--;
            updateCarousel();
        }

        function stopAutoScroll() {
            autoScroll = false;
            clearInterval(autoScrollInterval);
        }
    </script>
@endsection
