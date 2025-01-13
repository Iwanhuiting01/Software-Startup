@extends('layouts.app')

@section('content')
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="container mx-auto p-6 max-w-screen-lg">
                        <h1 class="text-3xl font-bold text-center mb-6">Welkom bij Dealtrip</h1>

                        <!-- vakanties carousel -->
                        <div class="carousel align-middle" style="width: 30rem; height: 25rem">
                            <div class="carousel-item">
                                <img src="{{url("/images/Alpen-wandelen.jpg")}}" alt="Alpen"/>
                            </div>

                            <div class="carousel-item">
                                <img src="{{url("/images/Griekenland-eilandhoppen.jpg")}}" alt="Griekenland">
                            </div>

                            <div class="carousel-item">
                                <img src="{{url("/images/Parijs-stedentrip.jpg")}}" alt="Parijs">
                            </div>
                        </div>
                        <a class="prev ml-12 mr-40 " onclick="plusSlides(-1)">&#10094;</a>
                        <a class="next ml-40" onclick="plusSlides(1)">&#10095;</a>
                    </div>
                </div>
            </div>

            <script type="text/javascript">
                let slideIndex = 1;
                showSlides(slideIndex);

                // Next/previous controls
                function plusSlides(n) {
                    showSlides(slideIndex += n);
                }

                // Thumbnail image controls
                function currentSlide(n) {
                    showSlides(slideIndex = n);
                }

                function showSlides(n) {
                    let i;
                    let slides = document.getElementsByClassName("carousel-item");
                    if (n > slides.length) {slideIndex = 1}
                    if (n < 1) {slideIndex = slides.length}
                    for (i = 0; i < slides.length; i++) {
                        slides[i].style.display = "none";
                    }
                    slides[slideIndex-1].style.display = "block";
                }
            </script>
        </div>
    </div>
@endsection
