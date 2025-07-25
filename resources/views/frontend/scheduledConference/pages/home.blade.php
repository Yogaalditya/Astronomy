<x-astronomy::layouts.main>

    <x-astronomy::layouts.banner></x-astronomy::layouts.banner>

    <div class="space-y-8">
        @php
            $layouts = App\Facades\Plugin::getPlugin('Astronomy')->getSetting('layouts');
            // dd($layouts)
        @endphp

        @if ($layouts)
            @foreach ($layouts as $layout)
                @switch($layout['type'])
                    @case('layouts')
                        <section @class([
                            Str::snake($layout['data']['name_content']) => true,
                            'prose prose-li: max-w-none w-full',
                        ])>
                            {{ new Illuminate\Support\HtmlString($layout['data']['about']) }}
                        </section>
                    @break
                    @case('speakers')
                        <x-scheduledConference::speakers />
                    @break
                    @case('sponsors')
                        @if ($sponsorLevels->isNotEmpty() || $sponsorsWithoutLevel->isNotEmpty())
                            <x-scheduledConference::sponsors :sponsorLevels="$sponsorLevels" :sponsorsWithoutLevel="$sponsorsWithoutLevel" :data="$layout['data']" />
                        @endif
                    @break
                    @case('partners')
                        @if ($partners->isNotEmpty())
                            <x-scheduledConference::partners :partners="$partners" />
                        @endif
                    @break
                    @case('latest-news')
                        @if ($currentScheduledConference)
                            <x-scheduledConference::latest-news />
                        @endif
                    @break
                @endswitch
            @endforeach
        @endif

        @if ($currentScheduledConference->getMeta('additional_content'))
            <div class="prose max-w-none">
                {{ new Illuminate\Support\HtmlString($currentScheduledConference->getMeta('additional_content')) }}
            </div>
        @endif

    </div>
</x-astronomy::layouts.main>
