@props(['sponsorLevels', 'sponsorsWithoutLevel'])

@php
    // Collect all sponsors with logos for carousel
    $allSponsors = collect();
    
    // Add sponsors without level
    if ($sponsorsWithoutLevel->isNotEmpty()) {
        foreach ($sponsorsWithoutLevel as $sponsor) {
            if ($sponsor->getFirstMedia('logo')) {
                $allSponsors->push([
                    'sponsor' => $sponsor,
                    'level' => null
                ]);
            }
        }
    }
    
    // Add sponsors with levels
    foreach ($sponsorLevels as $sponsorLevel) {
        if ($sponsorLevel->stakeholders->isNotEmpty()) {
            foreach ($sponsorLevel->stakeholders as $sponsor) {
                if ($sponsor->getFirstMedia('logo')) {
                    $allSponsors->push([
                        'sponsor' => $sponsor,
                        'level' => $sponsorLevel->name
                    ]);
                }
            }
        }
    }
    
    $totalSlides = $allSponsors->count();
@endphp

@if ($sponsorLevels->isNotEmpty() || $sponsorsWithoutLevel->isNotEmpty())
<section id="sponsors" class="section-background py-20">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 max-w-7xl">
        <!-- Section Header -->
        <div class="text-center max-w-3xl mx-auto mb-16">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">Our Sponsors</h2>
            <p class="text-gray-600 max-w-2xl mx-auto mt-4">Thank you to all our amazing sponsors who make our work possible</p>
        </div>

        @if($totalSlides > 0)
        <!-- Sponsors Carousel -->
        <div class="relative w-full max-w-4xl mx-auto">
            <!-- Navigation Arrows -->
            <button id="prevSponsor" class="absolute left-0 top-1/2 transform -translate-y-1/2 z-10 bg-white hover:bg-gray-100 rounded-full p-3 shadow-lg transition-all duration-300">
                <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
            </button>

            <button id="nextSponsor" class="absolute right-0 top-1/2 transform -translate-y-1/2 z-10 bg-white hover:bg-gray-100 rounded-full p-3 shadow-lg transition-all duration-300">
                <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
            </button>

            <!-- Sponsors Container -->
            <div class="overflow-hidden mx-12">
                <div id="sponsorsSlider" class="flex transition-transform duration-500 ease-in-out">
                    @foreach ($allSponsors as $index => $sponsorData)
                        @php 
                            $sponsor = $sponsorData['sponsor'];
                            $level = $sponsorData['level'];
                            $tag = $sponsor->getMeta('url') ? 'a' : 'div'; 
                        @endphp

                        <div class="flex-shrink-0 w-full flex flex-col items-center justify-center p-8">
                            @if($level)
                                <h3 class="text-xl font-semibold text-gray-700 mb-4">{{ $level }}</h3>
                            @endif
                            
                            <{{$tag}}
                                @if($sponsor->getMeta('url'))
                                href="{{ $sponsor->getMeta('url') }}"
                                target="_blank"
                                @endif
                                class="flex items-center justify-center transition duration-300 ease-in-out hover:scale-105">
                                <!-- Sponsor Logo -->
                                <img
                                    style="
                                        image-rendering: auto;
                                        width: auto;
                                        height: auto;
                                        object-fit: contain;
                                        max-width: 300px;
                                        max-height: 150px;
                                    "
                                    src="{{ $sponsor->getFirstMediaUrl('logo') }}"
                                    alt="{{ $sponsor->name }}"
                                    loading="lazy" />
                            </{{$tag}}>
                        </div>
                    @endforeach
                    
                    <!-- Duplicate first slide for infinite loop -->
                    @if($allSponsors->count() > 0)
                        @php 
                            $firstSponsor = $allSponsors->first();
                            $sponsor = $firstSponsor['sponsor'];
                            $level = $firstSponsor['level'];
                            $tag = $sponsor->getMeta('url') ? 'a' : 'div'; 
                        @endphp

                        <div class="flex-shrink-0 w-full flex flex-col items-center justify-center p-8">
                            @if($level)
                                <h3 class="text-xl font-semibold text-gray-700 mb-4">{{ $level }}</h3>
                            @endif
                            
                            <{{$tag}}
                                @if($sponsor->getMeta('url'))
                                href="{{ $sponsor->getMeta('url') }}"
                                target="_blank"
                                @endif
                                class="flex items-center justify-center transition duration-300 ease-in-out hover:scale-105">
                                <!-- Sponsor Logo -->
                                <img
                                    style="
                                        image-rendering: auto;
                                        width: auto;
                                        height: auto;
                                        object-fit: contain;
                                        max-width: 300px;
                                        max-height: 150px;
                                    "
                                    src="{{ $sponsor->getFirstMediaUrl('logo') }}"
                                    alt="{{ $sponsor->name }}"
                                    loading="lazy" />
                            </{{$tag}}>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Indicators -->
            <div class="flex justify-center mt-6 space-x-2">
                @foreach ($allSponsors as $index => $sponsorData)
                    <button class="sponsor-indicator w-3 h-3 rounded-full bg-gray-300 transition-colors duration-300" data-slide="{{ $index }}"></button>
                @endforeach
            </div>
        </div>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const slider = document.getElementById('sponsorsSlider');
                const indicators = document.querySelectorAll('.sponsor-indicator');
                const prevBtn = document.getElementById('prevSponsor');
                const nextBtn = document.getElementById('nextSponsor');

                const totalSlides = {{ $totalSlides ?? 0 }};
                let currentSlide = 0;
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
                            indicator.classList.add('bg-blue-600');
                            indicator.classList.remove('bg-gray-300');
                        } else {
                            indicator.classList.remove('bg-blue-600');
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