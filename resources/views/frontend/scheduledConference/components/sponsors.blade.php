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
    <div class="sponsors-container">
        <div class="text-center max-w-3xl mx-auto mb-16">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">Our Sponsors</h2>
            <p class="text-gray-600 max-w-2xl mx-auto mt-4">Thank you to all our amazing sponsors who make our work possible</p>
        </div>

        @if($totalSlides > 0)
        <div class="relative w-full max-w-7xl mx-auto">

            <div id="sponsorsSlider" class="splide">
                <div class="splide__track">
                    <ul class="splide__list">
                        @foreach ($allSponsors as $sponsorData)
                            @php 
                                $sponsor = $sponsorData['sponsor'];
                                $level = $sponsorData['level'];
                                $tag = $sponsor->getMeta('url') ? 'a' : 'div';
                            @endphp

                            <li class="splide__slide flex flex-col items-center justify-center p-4">
                                @if($level)
                                    <h3 class="text-xl font-semibold text-gray-700 mb-4 text-center">{{ $level }}</h3>
                                @endif

                                <{{ $tag }}
                                    @if($sponsor->getMeta('url'))
                                    href="{{ $sponsor->getMeta('url') }}"
                                    target="_blank"
                                    @endif
                                    class="flex items-center justify-center w-full h-full transition duration-300 ease-in-out hover:scale-105">
                                    <div class="flex items-center justify-center w-full h-32">
                                        <img
                                            style="
                                                max-width: 200px;
                                                max-height: 100px;
                                                object-fit: contain;
                                            "
                                            src="{{ $sponsor->getFirstMediaUrl('logo') }}"
                                            alt="{{ $sponsor->name }}"
                                            loading="lazy" />
                                    </div>
                                </{{ $tag }}>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>

        <style>
            .splide__pagination__page {
                background: #ccc;
            }

            .splide__pagination__page.is-active {
                background: #022f73;
            }
        </style>

        <script>
            document.addEventListener('DOMContentLoaded', function () {
                new Splide('#sponsorsSlider', {
                    type      : 'loop',
                    drag      : 'free',
                    focus     : 'center',
                    perPage   : 3,
                    gap       : '1rem',
                    arrows    : true,
                    pagination: false,
                    autoScroll: {
                        speed: 1,
                    },
                    breakpoints: {
                        768: {
                            perPage: 3,
                            gap: '0.5rem',
                        },
                        480: {
                            perPage: 2,
                            gap: '1rem',
                        },
                    },
                }).mount(window.splide.Extensions);
            });
        </script>

        @endif
    </div>
</section>
@endif