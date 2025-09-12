@props([
    'data' => [],
])

@php
    // Data mapping for hero
    $title = $data['title'] ?? '';
    $description = $data['description'] ?? '';
    $buttons = $data['buttons'] ?? [];
    $backgroundUrl = $data['background_url'] ?? null;

    if (!$backgroundUrl) {
        try {
            if (isset($currentScheduledConference)) {
                $media = $currentScheduledConference->getMedia('astronomy-hero')->first();
                if ($media) {
                    $backgroundUrl = $media->getUrl()
                        ?: $media->getAvailableUrl(['thumb-xl'])
                        ?: $media->getAvailableUrl(['thumb']);

                    if ($backgroundUrl && !str_starts_with($backgroundUrl, 'http')) {
                        $backgroundUrl = asset($backgroundUrl);
                    }
                }
            }
        } catch (\Throwable $e) {
            // ignore silently
        }
    }
@endphp

@if ($title)
<section class="ny2026-hero" aria-labelledby="ny2026-hero-title"
    @if($backgroundUrl)
        style="background-image: linear-gradient(rgba(0,0,0,0.45), rgba(0,0,0,0.45)), url('{{ $backgroundUrl }}'); background-size: cover; background-position: center;"
    @endif
>
  <div class="ny2026-container">
    <div class="ny2026-hero__content">
      <h1 id="ny2026-hero-title" class="ny2026-hero__title">{{ $title }}</h1>
      @if($description)
        <p class="ny2026-hero__subtitle mt-[28px]">{{ $description }}</p>
      @endif
      @if(!empty($buttons))
      <div class="ny2026-hero__actions">
        @foreach($buttons as $btn)
            @php
                $buttonStyle = $btn['style'] ?? 'primary';

                $style = 'ny2026-btn--primary';
                if ($buttonStyle === 'outline') {
                    $style = 'ny2026-btn--outline';
                }

                $bgColor = $btn['background_color'] ?? null;
                $textColor = $btn['text_color'] ?? null;
            @endphp
            <a 
                @style([
                    'background-color: ' . $bgColor => !empty($bgColor),
                    'color: ' . $textColor => !empty($textColor),
                ])
                href="{{ $btn['url'] ?? '#' }}" 
                class="ny2026-btn {{ $style }}"
            >
                {{ $btn['text'] ?? '' }}
            </a>
        @endforeach
      </div>
      @endif
    </div>
  </div>
</section>
@endif