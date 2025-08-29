@php
    $images = $currentScheduledConference->getMedia('astronomy-header');
    $bannerImage = $images->first();
    $bannerUrl = '';
    
    if ($bannerImage) {
        // Use original image for better quality, fallback to smaller sizes
        $bannerUrl = $bannerImage->getUrl() ?: 
                     $bannerImage->getAvailableUrl(['thumb-xl']) ?: 
                     $bannerImage->getAvailableUrl(['thumb']);
        
        // Ensure proper URL format
        if ($bannerUrl && !str_starts_with($bannerUrl, 'http')) {
            $bannerUrl = asset($bannerUrl);
        }
    }
    
    // Debug info (remove after testing)
    //dd('Images count: ' . $images->count() . ', Banner URL: ' . $bannerUrl . ', Image exists: ' . ($bannerImage ? 'Yes' : 'No'));
    
    // Create unique ID for this banner
    $bannerId = 'banner-' . uniqid();

    $imagess = $currentScheduledConference->getMedia('astronomy-countdown')->first();
    $imagecountdown = $imagess ? $imagess->getAvailableUrl(['thumb', 'thumb-xl']) : null;
    $bannerHeight = $theme->getSetting('banner_height') ?? '700px';
@endphp

<section 
    id="{{ $bannerId }}" 
    class="hero-banner relative w-full -mt-16 flex items-center justify-center text-white mb-[220px] md:mb-[200px] @if(!$bannerUrl) bg-gradient-to-br from-indigo-500 to-purple-600 @endif"
    style="
        height: {{ $bannerHeight }};
        @if($bannerUrl)
        background-image: linear-gradient(rgba(0,0,0,0.4), rgba(0,0,0,0.4)), url('{{ $bannerUrl }}');
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
        background-attachment: scroll;
        @endif
    "
>
<script src="{{ asset('js/astronomy.js') }}"></script>
    <div class="container mx-auto px-4 z-10">
        <div class="text-left max-w-4xl mx-auto">
            <div class="w-full">
                <h1 class="font-bold text-3xl md:text-5xl lg:text-7xl tracking-tight mb-8 drop-shadow-2xl color-latest">{{ $currentScheduledConference->title }}</h1>
                @if($theme->getSetting('description'))
                    <p class="text-[17px] mb-8" style="color: {{ $theme->getSetting('description_color') }}"> {!! nl2br(e($theme->getSetting('description'))) !!}</p>    
                @endif
                <div class="flex flex-col space-y-4 mb-8 justify-start items-start">
                    @if($currentScheduledConference->date_start || $currentScheduledConference->date_end)
                        <div class="flex items-center justify-start">
                            <span class="icon-banner mr-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                            </span>
                            <div class="text-left">
                                @if($currentScheduledConference->date_start)
                                    @if($currentScheduledConference->date_end && $currentScheduledConference->date_start->format(Setting::get('format_date')) !== $currentScheduledConference->date_end->format(Setting::get('format_date')))
                                        <span class="font-semibold color-latest text-xl">{{ $currentScheduledConference->date_start->format(Setting::get('format_date')) }}</span>
                                        <span class="font-semibold color-latest text-xl"> - {{ $currentScheduledConference->date_end->format(Setting::get('format_date')) }}</span>
                                    @else
                                        <span class="font-semibold color-latest text-xl">{{ $currentScheduledConference->date_start->format(Setting::get('format_date')) }}</span>
                                    @endif
                                @endif
                                <div class="text-base text-white mt-1">Conference Dates</div>
                            </div>
                        </div>
                    @endif
                    
                    <div class="flex items-center justify-start">
                        <span class="icon-banner mr-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                        </span>
                        <div class="text-left">
                            <span class="font-semibold color-latest text-xl">{{ new Illuminate\Support\HtmlString($currentScheduledConference->getMeta('location') ?? 'To be announced') }}</span>
                            <div class="text-base text-white mt-1">Conference Venue</div>
                        </div>
                    </div>
                </div>
                @if($theme->getSetting('banner_buttons'))
                <div class="flex flex-col flex-wrap sm:flex-row gap-4 justify-start">
                    @foreach($theme->getSetting('banner_buttons') ?? [] as $button)
                        <a 
                            @style([
                                'background-color: ' . data_get($button, 'background_color') => data_get($button, 'background_color'),
                                'color: ' . data_get($button, 'text_color') => data_get($button, 'text_color'), 
                            ])
                            href="{{ data_get($button, 'url') }}" 
                            class="button-banner px-4 py-3 rounded-xl font-semibold text-sm transition-all duration-300 hover:scale-105 shadow-lg"
                            >
                            {{ data_get($button, 'text') }}
                        </a>
                    @endforeach
                </div>
                @endif
            </div>
        </div>
    </div>

<div class="countdown-section absolute left-0 right-0 -bottom-24 md:-bottom-20 z-20 ">
  <div class="animate-slideUp delay-500 countdown-con mx-auto backdrop-blur-md bg-white rounded-3xl shadow-2xl overflow-hidden w-full max-w-[1020px] h-auto">

    <div class="flex flex-col md:flex-row items-center h-full">
      
      <!-- Header -->
      <div class="bg-custom-color px-6 py-4 md:py-0 self-stretch flex items-center justify-center md:justify-start w-full md:w-auto rounded-l-3xl md:rounded-l-3xl md:rounded-r-none">
        <span class="font-extrabold text-lg md:text-xl leading-tight text-gradient text-center md:text-left">
          Our Event <br class="hidden md:block"> Program Starts In :
        </span>
      </div>

      <!-- Countdown -->
      <div class="countdown-container flex flex-1 items-center justify-around text-center bg-white px-3 md:px-6 h-full">

        <!-- Days -->
        <div class="flex flex-row md:flex-col items-center justify-center gap-1">
          <div id="days" class="text-gradient text-2xl md:text-5xl font-bold">00</div>
          <div class="uppercase text-xs md:text-sm text-gray-500">Days</div>
        </div>
        <!-- Divider (desktop only) -->
        <div class="hidden md:block w-0.5 bg-gray-200 self-center h-[1em] text-2xl md:text-5xl mx-2 md:mx-4" aria-hidden="true"></div>

        <!-- Hours -->
        <div class="flex flex-row md:flex-col items-center justify-center gap-1">
          <div id="hours" class="text-gradient text-2xl md:text-5xl font-bold">00</div>
          <div class="uppercase text-xs md:text-sm text-gray-500">Hours</div>
        </div>
        <!-- Divider (desktop only) -->
        <div class="hidden md:block w-0.5 bg-gray-200 self-center h-[1em] text-2xl md:text-5xl mx-2 md:mx-4" aria-hidden="true"></div>

        <!-- Minutes -->
        <div class="flex flex-row md:flex-col items-center justify-center gap-1">
          <div id="minutes" class="text-gradient text-2xl md:text-5xl font-bold">00</div>
          <div class="uppercase text-xs md:text-sm text-gray-500">Minutes</div>
        </div>
        <!-- Divider (desktop only) -->
        <div class="hidden md:block w-0.5 bg-gray-200 self-center h-[1em] text-2xl md:text-5xl mx-2 md:mx-4" aria-hidden="true"></div>

        <!-- Seconds -->
        <div class="flex flex-row md:flex-col items-center justify-center gap-1">
          <div id="seconds" class="text-gradient text-2xl md:text-5xl font-bold">00</div>
          <div class="uppercase text-xs md:text-sm text-gray-500">Seconds</div>
        </div>

      </div>

    </div>

  </div>
</div>



</section>

<style>
@keyframes gradient {
    0% { background-position: 0% 50%; }
    50% { background-position: 100% 50%; }
    100% { background-position: 0% 50%; }
}

.animate-gradient {
    background-size: 200% 200%;
    animation: gradient 15s ease infinite;
}

@keyframes fadeIn {
    from { opacity: 0; }
    to { opacity: 1; }
}

.animate-fadeIn {
    animation: fadeIn 1s ease-out forwards;
}

@keyframes slideUp {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.animate-slideUp {
    opacity: 0;
    animation: slideUp 0.6s ease-out forwards;
}

@keyframes popIn {
    0% {
        opacity: 0;
        transform: scale(0.8);
    }
    80% {
        transform: scale(1.1);
    }
    100% {
        opacity: 1;
        transform: scale(1);
    }
}

.animate-popIn {
    opacity: 0;
    animation: popIn 0.5s ease-out forwards;
}

.delay-100 { animation-delay: 0.1s; }
.delay-200 { animation-delay: 0.2s; }
.delay-300 { animation-delay: 0.3s; }
.delay-400 { animation-delay: 0.4s; }
.delay-500 { animation-delay: 0.5s; }
.delay-600 { animation-delay: 0.6s; }
.delay-700 { animation-delay: 0.7s; }
.delay-800 { animation-delay: 0.8s; }
.delay-900 { animation-delay: 0.9s; }

/* Increase countdown height */
.countdown-con {
    height: 140px;
}


</style>

<script>
    function updateCountdown() {
        const endDate = new Date("{{ $currentScheduledConference->date_end ? $currentScheduledConference->date_end->toIso8601String() : ($currentScheduledConference->date_start ? $currentScheduledConference->date_start->toIso8601String() : '') }}").getTime();
        const now = Date.now();
        const timeLeft = endDate - now;

        if (!endDate) {
            return;
        }

        if (timeLeft >= 0) {
            const days = Math.floor(timeLeft / (1000 * 60 * 60 * 24));
            const hours = Math.floor((timeLeft % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            const minutes = Math.floor((timeLeft % (1000 * 60 * 60)) / (1000 * 60));
            const seconds = Math.floor((timeLeft % (1000 * 60)) / 1000);

            document.getElementById('days').innerText = days.toString().padStart(2, '0');
            document.getElementById('hours').innerText = hours.toString().padStart(2, '0');
            document.getElementById('minutes').innerText = minutes.toString().padStart(2, '0');
            document.getElementById('seconds').innerText = seconds.toString().padStart(2, '0');
        } else {
            clearInterval(countdownTimer);
            document.querySelector('.countdown-section').innerHTML = '<div class="text-2xl text-center text-gray-600">Event has ended!</div>';
        }
    }

    const countdownTimer = setInterval(updateCountdown, 1000);
    updateCountdown();
    
</script>

