@props(['partners'])

@if ($partners->isNotEmpty())
<section class="py-20">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 max-w-7xl">
        <!-- Section Header -->
        <div class="text-center max-w-3xl mx-auto mb-16">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">Our Partners</h2>
        </div>

        <!-- Partners Carousel -->
        <div class="relative w-full max-w-4xl mx-auto">
            <!-- Navigation Arrows -->
            <button id="prevPartner" class="absolute left-0 top-1/2 transform -translate-y-1/2 z-10 bg-white hover:bg-gray-100 rounded-full p-3 shadow-lg transition-all duration-300">
                <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
            </button>

            <button id="nextPartner" class="absolute right-0 top-1/2 transform -translate-y-1/2 z-10 bg-white hover:bg-gray-100 rounded-full p-3 shadow-lg transition-all duration-300">
                <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
            </button>

            <!-- Partners Container -->
            <div class="overflow-hidden mx-12">
                <div id="partnersSlider" class="flex transition-transform duration-500 ease-in-out">
                    @foreach ($partners as $index => $partner)
                    @if (!$partner->getFirstMedia('logo'))
                    @continue
                    @endif
                    @php $tag = $partner->getMeta('url') ? 'a' : 'div'; @endphp

                    <div class="flex-shrink-0 w-full flex items-center justify-center p-8">
                        <{{$tag}}
                            @if($partner->getMeta('url'))
                            href="{{ $partner->getMeta('url') }}"
                            target="_blank"
                            @endif
                            class="flex items-center justify-center transition duration-300 ease-in-out hover:scale-105">
                            <!-- Partner Logo -->
                            <img
                                style="
										image-rendering: auto;
										width: auto;
										height: auto;
										object-fit: contain;
										max-width: 250px;
										max-height: 120px;
									"
                                src="{{ $partner->getFirstMediaUrl('logo') }}"
                                alt="{{ $partner->name }}"
                                loading="lazy" />
                        </{{$tag}}>
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- Indicators -->
            <div class="flex justify-center mt-6 space-x-2">
                @foreach ($partners as $index => $partner)
                @if (!$partner->getFirstMedia('logo'))
                @continue
                @endif
                <button class="indicator w-3 h-3 rounded-full bg-gray-300 transition-colors duration-300" data-slide="{{ $loop->iteration - 1 }}"></button>
                @endforeach
            </div>
        </div>

        @php
            $validPartners = $partners->filter(function($partner) {
                return $partner->getFirstMedia('logo');
            });
            $totalSlides = $validPartners->count();
        @endphp

        @if($totalSlides > 0)
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const slider = document.getElementById('partnersSlider');
                const indicators = document.querySelectorAll('.indicator');
                const prevBtn = document.getElementById('prevPartner');
                const nextBtn = document.getElementById('nextPartner');

                const totalSlides = {{ $totalSlides }};
                let currentSlide = 0 ;
                let autoSlideInterval;

                function updateSlider() {
                    slider.style.transform = 'translateX(-' + (currentSlide * 100) + '%)';

                    // Update indicators
                    indicators.forEach(function(indicator, index) {
                        if (index === currentSlide) {
                            indicator.classList.add('bg-blue-600');
                            indicator.classList.remove('bg-gray-300');
                        } else {
                            indicator.classList.remove('bg-blue-600');
                            indicator.classList.add('bg-gray-300');
                        }
                    });
                }

                function nextSlide() {
                    currentSlide = (currentSlide + 1) % totalSlides;
                    updateSlider();
                }

                function prevSlide() {
                    currentSlide = (currentSlide - 1 + totalSlides) % totalSlides;
                    updateSlider();
                }

                function goToSlide(index) {
                    currentSlide = index;
                    updateSlider();
                }

                function startAutoSlide() {
                    autoSlideInterval = setInterval(nextSlide, 5000);
                }

                function stopAutoSlide() {
                    clearInterval(autoSlideInterval);
                }

                // Event listeners
                nextBtn.addEventListener('click', function() {
                    stopAutoSlide();
                    nextSlide();
                    startAutoSlide();
                });

                prevBtn.addEventListener('click', function() {
                    stopAutoSlide();
                    prevSlide();
                    startAutoSlide();
                });

                indicators.forEach(function(indicator, index) {
                    indicator.addEventListener('click', function() {
                        stopAutoSlide();
                        goToSlide(index);
                        startAutoSlide();
                    });
                });

                // Pause on hover
                slider.parentElement.addEventListener('mouseenter', stopAutoSlide);
                slider.parentElement.addEventListener('mouseleave', startAutoSlide);

                // Initialize
                updateSlider();
                startAutoSlide();
            });
        </script>
        @endif

</section>
@endif