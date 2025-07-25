@props([
    'title' => null,
])
<x-astronomy::layouts.base :title="$title">
    <div class="flex h-full min-h-screen flex-col">
        @hook('Frontend::Views::Header')

        {{-- Load Header Layout --}}
        <x-astronomy::layouts.header />


        <main class="py-3 ">
            {{-- Load Main Layout --}}
            {{ $slot }}
        </main>

        {{-- Load Footer Layout --}}
        <x-astronomy::layouts.footer />

        @hook('Frontend::Views::Footer')
    </div>
</x-astronomy::layouts.base>

