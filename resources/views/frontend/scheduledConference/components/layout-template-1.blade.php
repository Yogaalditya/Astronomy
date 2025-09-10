@props([
    'data' => [],
])

@php
    // Expecting $data['section_title'] as string and $data['cards'] as list
    $sectionTitle = $data['section_title'] ?? null;
    $cards = $data['cards'] ?? [];
    $cardCount = count($cards);
@endphp
    
@if (!empty($cards))
<section class="ny2026-benefits py-8 md:py-12" aria-labelledby="ny2026-benefits-title">
    <div class="ny2026-container">
        @if ($sectionTitle)
            <h2 id="ny2026-benefits-title" class="ny2026-section__title mb-6">{{ $sectionTitle }}</h2>
        @endif
        <div class="ny2026-cards ny2026-cards--grid gap-6" data-card-count="{{ $cardCount }}">
            @foreach ($cards as $card)
                <article class="ny2026-card ny2026-card--benefit px-5 pt-10 pb-5 md:px-5 pt-10 pb-5">
                    <h3 class="ny2026-card__title mb-2 text-xl">{{ $card['title'] ?? '' }}</h3>
                    <p class="ny2026-card__text">{{ $card['description'] ?? '' }}</p>
                </article>
            @endforeach
        </div>
    </div>
</section>
@endif
