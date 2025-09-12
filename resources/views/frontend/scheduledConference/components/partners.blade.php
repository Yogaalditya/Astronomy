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
    <div class="partners-container">
        <!-- Section Header -->
        <div class="text-center max-w-3xl mx-auto mb-16">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">Our Partners</h2>
            <p class="text-gray-600 max-w-2xl mx-auto mt-4">Special thanks to our incredible partners for being part of our journey.</p>
        </div>

        @if ($totalSlides > 0)
        <!-- Partners Carousel -->
        <div class="relative w-full max-w-7xl mx-auto">

            <!-- Partners Container -->
            <div id="partnersSlider" class="splide">
                <div class="splide__track">
                    <ul class="splide__list">
                        @foreach ($partnersWithLogos as $partner)
                            @php $tag = $partner->getMeta('url') ? 'a' : 'div'; @endphp

                            <li class="splide__slide flex items-center justify-center p-4">
                                <{{$tag}}
                                    @if($partner->getMeta('url'))
                                    href="{{ $partner->getMeta('url') }}"
                                    target="_blank"
                                    @endif
                                    class="flex items-center justify-center transition duration-300 ease-in-out hover:scale-105">
                                    <img
                                        style="
                                            max-width: 200px;
                                            max-height: 100px;
                                            object-fit: contain;
                                        "
                                        src="{{ $partner->getFirstMediaUrl('logo') }}"
                                        alt="{{ $partner->name }}"
                                        loading="lazy" />
                                </{{$tag}}>
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
                new Splide('#partnersSlider', {
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
                            gap: '0.5rem',
                        },
                    },
                }).mount(window.splide.Extensions);
            });
        </script>

        @endif

    </div>
</section>
@endif