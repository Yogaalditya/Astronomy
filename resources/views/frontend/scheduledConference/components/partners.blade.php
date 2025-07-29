@props(['partners'])

@php
    // Filter partners with logos for carousel
    $partnersWithLogos = $partners->filter(function($partner) {
        return $partner->getFirstMedia('logo');
    });
    
    $totalSlides = $partnersWithLogos->count();
@endphp

@if ($partnersWithLogos->isNotEmpty())
<section class="py-20">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 max-w-7xl">
        <!-- Section Header -->
        <div class="text-center max-w-3xl mx-auto mb-16">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">Our Partners</h2>
        </div>

        @if ($totalSlides > 0)
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
                    @foreach ($partnersWithLogos as $index => $partner)
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
                    
                    <!-- Duplicate first slide for infinite loop -->
                    @if($partnersWithLogos->count() > 0)
                        @php 
                            $firstPartner = $partnersWithLogos->first();
                            $tag = $firstPartner->getMeta('url') ? 'a' : 'div'; 
                        @endphp

                        <div class="flex-shrink-0 w-full flex items-center justify-center p-8">
                            <{{$tag}}
                                @if($firstPartner->getMeta('url'))
                                href="{{ $firstPartner->getMeta('url') }}"
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
                                    src="{{ $firstPartner->getFirstMediaUrl('logo') }}"
                                    alt="{{ $firstPartner->name }}"
                                    loading="lazy" />
                            </{{$tag}}>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Indicators -->
            <div class="flex justify-center mt-6 space-x-2">
                @foreach ($partnersWithLogos as $index => $partner)
                    <button class="indicator w-3 h-3 rounded-full bg-gray-300 transition-colors duration-300" data-slide="{{ $index }}"></button>
                @endforeach
            </div>
        </div>


        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const slider = document.getElementById('partnersSlider');
                const indicators = document.querySelectorAll('.indicator');
                const prevBtn = document.getElementById('prevPartner');
                const nextBtn = document.getElementById('nextPartner');

                const totalSlides = {{ $totalSlides ?? 0}};
                let currentSlide = 0 ;
                let autoSlideInterval;
                let isTransitioning = false;

                function updateSlider(withTransition = true) {
                    if (withTransition) {
                        slider.style.transition = 'transform 0.5s ease-in-out';
                    } else {
                        slider.style.transition = 'none';
                    }
                    
                    slider.style.transform = 'translateX(-' + (currentSlide * 100) + '%)';

                    // Update indicators
                    const indicatorIndex = currentSlide >= totalSlides ? 0 : currentSlide;
                    indicators.forEach(function(indicator, index) {
                        if (index === indicatorIndex) {
                            indicator.classList.add('bg-blue-500');
                            indicator.classList.remove('bg-gray-300');
                        } else {
                            indicator.classList.remove('bg-blue-500');
                            indicator.classList.add('bg-gray-300');
                        }
                    });
                }

                function nextSlide() {
                    if (isTransitioning) return;
                    
                    isTransitioning = true;
                    currentSlide++;
                    updateSlider(true);

                    // If we're at the duplicate slide (totalSlides), reset to first slide without animation
                    if (currentSlide >= totalSlides) {
                        setTimeout(function() {
                            currentSlide = 0;
                            updateSlider(false);
                            isTransitioning = false;
                        }, 500); // Wait for transition to complete
                    } else {
                        setTimeout(function() {
                            isTransitioning = false;
                        }, 500);
                    }
                }

                function prevSlide() {
                    if (isTransitioning) return;
                    
                    isTransitioning = true;
                    
                    if (currentSlide === 0) {
                        // Jump to duplicate slide without animation, then animate to last real slide
                        currentSlide = totalSlides;
                        updateSlider(false);
                        
                        setTimeout(function() {
                            currentSlide = totalSlides - 1;
                            updateSlider(true);
                            setTimeout(function() {
                                isTransitioning = false;
                            }, 500);
                        }, 50);
                    } else {
                        currentSlide--;
                        updateSlider(true);
                        setTimeout(function() {
                            isTransitioning = false;
                        }, 500);
                    }
                }

                function goToSlide(index) {
                    if (isTransitioning) return;
                    
                    isTransitioning = true;
                    currentSlide = index;
                    updateSlider(true);
                    setTimeout(function() {
                        isTransitioning = false;
                    }, 500);
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

    </div>
</section>
@endif