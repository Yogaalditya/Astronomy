<x-astronomy::layouts.main>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Breadcrumbs Section -->
        <div class="mb-6">
            <x-astronomy::breadcrumbs 
                :breadcrumbs="$this->getBreadcrumbs()" 
                class="text-sm text-gray-600 transition-colors duration-300" 
            />
        </div>

        <!-- Header/Hero -->
        <section class="relative mb-8 overflow-hidden rounded-2xl border border-indigo-100 bg-gradient-to-r from-sky-50 to-indigo-50 p-6 sm:p-8 transition-colors duration-300">
            <div class="absolute inset-x-0 top-0 h-px bg-gradient-to-r from-transparent via-indigo-200 to-transparent"></div>
            <div class="flex items-start justify-between gap-4">
                <div>
                    <h1 class="text-3xl sm:text-4xl font-extrabold text-gray-900">{{ $this->getTitle() }}</h1>
                    @if (!$about)
                        <p class="mt-2 text-gray-600 max-w-2xl">Learn more about this conference.</p>
                    @endif
                </div>
                <div class="hidden sm:flex items-center justify-center rounded-xl bg-white/70 p-3 ring-1 ring-inset ring-indigo-100">
                    <!-- Info Icon -->
                    <svg class="h-7 w-7 text-indigo-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <circle cx="12" cy="12" r="10" />
                        <path d="M12 16v-4" />
                        <path d="M12 8h.01" />
                    </svg>
                </div>
            </div>
        </section>

        @if ($about)
            <article class="group relative rounded-xl border border-gray-200 bg-white p-5 shadow-sm transition-all duration-300">
                <div class="absolute inset-x-0 -top-px h-px bg-gradient-to-r from-transparent via-indigo-200 to-transparent"></div>
                <div class="prose max-w-none layout-section" style="--tw-prose-body:#000000">
                    {{ new Illuminate\Support\HtmlString($about) }}
                </div>
            </article>
        @else
            <div class="rounded-2xl border border-dashed border-gray-300 bg-white p-10 text-center shadow-sm">
                <div class="mx-auto mb-3 flex h-12 w-12 items-center justify-center rounded-full bg-gray-50 text-gray-400 ring-1 ring-inset ring-gray-200">
                    <!-- Info Icon -->
                    <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <circle cx="12" cy="12" r="10" />
                        <path d="M12 16v-4" />
                        <path d="M12 8h.01" />
                    </svg>
                </div>
                <h2 class="text-lg font-semibold text-gray-900">No information provided at this time.</h2>
                <p class="mt-1 text-gray-500">Check back later for updates.</p>
            </div>
        @endif
    </div>
</x-astronomy::layouts.main>