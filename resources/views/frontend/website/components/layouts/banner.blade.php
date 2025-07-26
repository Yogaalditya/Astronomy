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
@endphp

<section 
    id="{{ $bannerId }}" 
    class="hero-banner relative min-h-screen w-full -mt-16 flex items-center justify-center text-white @if(!$bannerUrl) bg-gradient-to-br from-indigo-500 to-purple-600 @endif"
    @if($bannerUrl)
    style="
        background-image: linear-gradient(rgba(0,0,0,0.4), rgba(0,0,0,0.4)), url('{{ $bannerUrl }}');
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
        background-attachment: scroll;
    "
    @endif
>
    <div class="container mx-auto px-4 z-10">
        <div class="text-center max-w-4xl mx-auto">
            <div class="w-full">
                <h1 class="font-bold text-3xl lg:text-7xl tracking-tight mb-8 drop-shadow-2xl text-white">{{ $currentScheduledConference->title }}</h1>
                <div class="flex flex-col space-y-4 mb-8 justify-center items-center">
                    @if($currentScheduledConference->date_start || $currentScheduledConference->date_end)
                        <div class="flex items-center justify-center">
                            <span class="icon-banner mr-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-1 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                            </span>
                            <div class="text-center">
                                @if($currentScheduledConference->date_start)
                                    @if($currentScheduledConference->date_end && $currentScheduledConference->date_start->format(Setting::get('format_date')) !== $currentScheduledConference->date_end->format(Setting::get('format_date')))
                                        <span cla ss="font-semibold text-white text-lg">{{ $currentScheduledConference->date_start->format(Setting::get('format_date')) }}</span>
                                        <span class="font-semibold text-white text-lg"> - {{ $currentScheduledConference->date_end->format(Setting::get('format_date')) }}</span>
                                    @else
                                        <span class="font-semibold text-white text-lg">{{ $currentScheduledConference->date_start->format(Setting::get('format_date')) }}</span>
                                    @endif
                                @endif
                                <div class="text-sm text-gray-200 mt-1">Conference Dates</div>
                            </div>
                        </div>
                    @endif
                    
                    <div class="flex items-center justify-center">
                        <span class="icon-banner mr-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-1 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                        </span>
                        <div class="text-center">
                            <span class="font-semibold text-white text-lg">{{ new Illuminate\Support\HtmlString($currentScheduledConference->getMeta('location') ?? 'To be announced') }}</span>
                            <div class="text-sm text-gray-200 mt-1">Conference Venue</div>
                        </div>
                    </div>
                </div>
                @if($theme->getSetting('banner_buttons'))
                <div class="flex flex-col flex-wrap sm:flex-row gap-4 justify-center">
                    @foreach($theme->getSetting('banner_buttons') ?? [] as $button)
                        <a 
                            @style([
                                'background-color: ' . data_get($button, 'background_color') => data_get($button, 'background_color'),
                                'color: ' . data_get($button, 'text_color') => data_get($button, 'text_color'), 
                            ])
                            href="{{ data_get($button, 'url') }}" 
                            class="button-banner px-8 py-4 rounded-lg font-semibold text-lg transition-all duration-300 hover:scale-105 shadow-lg"
                            >
                            {{ data_get($button, 'text') }}
                        </a>
                    @endforeach
                </div>
                @endif
            </div>
        </div>
    </div>
</section>
