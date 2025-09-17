@props([
    'data' => [],
])

@php
    $left = $data['left'] ?? [];
    $right = $data['right'] ?? [];

    $leftType = $left['type'] ?? null;
    $rightType = $right['type'] ?? null;

    // Resolve image URLs with fallbacks to media collections
    $leftUrl = $left['image_url'] ?? null;
    if (!$leftUrl) {
        try {
            if (isset($currentScheduledConference)) {
                $media = $currentScheduledConference->getMedia('astronomy-about-left')->first();
                if ($media) {
                    $leftUrl = $media->getUrl()
                        ?: $media->getAvailableUrl(['thumb-xl'])
                        ?: $media->getAvailableUrl(['thumb']);

                    if ($leftUrl && !str_starts_with($leftUrl, 'http')) {
                        $leftUrl = asset($leftUrl);
                    }
                }
            }
        } catch (\Throwable $e) {
            
        }
    }

    $rightUrl = $right['image_url'] ?? null;
    if (!$rightUrl) {
        try {
            if (isset($currentScheduledConference)) {
                $media = $currentScheduledConference->getMedia('astronomy-about-right')->first();
                if ($media) {
                    $rightUrl = $media->getUrl()
                        ?: $media->getAvailableUrl(['thumb-xl'])
                        ?: $media->getAvailableUrl(['thumb']);

                    if ($rightUrl && !str_starts_with($rightUrl, 'http')) {
                        $rightUrl = asset($rightUrl);
                    }
                }
            }
        } catch (\Throwable $e) {
            
        }
    }

    $leftPoints = $left['points'] ?? [];
    $rightPoints = $right['points'] ?? [];
@endphp

<section class="ny2026-about py-8 md:py-12" aria-labelledby="ny2026-about-title">
  <div class="ny2026-container ny2026-about__grid gap-8">
    <div class="ny2026-about__text">
      @if(($leftType === 'description') && (!empty($left['title']) || !empty($left['description']) || !empty($leftPoints)))
        @if(!empty($left['title']))
          <h2 id="ny2026-about-title" class="ny2026-section__title">{{ $left['title'] }}</h2>
        @endif
        @if(!empty($left['description']))
          <p class="ny2026-section__lead">{{ $left['description'] }}</p>
        @endif
        @if(!empty($leftPoints))
          <ul class="ny2026-list ny2026-list--check">
            @foreach($leftPoints as $p)
              <li>{{ $p['text'] ?? '' }}</li>
            @endforeach
          </ul>
        @endif
      @elseif($leftType === 'image' && $leftUrl)
        <div class="ny2026-about__media">
          <img src="{{ $leftUrl }}" alt="About image left" class="ny2026-image" />
        </div>
      @endif
    </div>

    <div class="ny2026-about__media">
      @if(($rightType === 'description') && (!empty($right['title']) || !empty($right['description']) || !empty($rightPoints)))
        @if(!empty($right['title']))
          <h2 class="ny2026-section__title">{{ $right['title'] }}</h2>
        @endif
        @if(!empty($right['description']))
          <p class="ny2026-section__lead">{{ $right['description'] }}</p>
        @endif
        @if(!empty($rightPoints))
          <ul class="ny2026-list ny2026-list--check">
            @foreach($rightPoints as $p)
              <li>{{ $p['text'] ?? '' }}</li>
            @endforeach
          </ul>
        @endif
      @elseif($rightType === 'image' && $rightUrl)
        <img src="{{ $rightUrl }}" alt="About image right" class="ny2026-image" />
      @endif
    </div>
  </div>
</section>