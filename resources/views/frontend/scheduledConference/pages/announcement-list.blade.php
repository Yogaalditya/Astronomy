<x-astronomy::layouts.main>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
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
                    <h1 class="text-3xl sm:text-4xl font-extrabold text-gray-900">Announcements</h1>
                    <p class="mt-2 text-gray-600 max-w-2xl">Stay up to date with the latest announcements from the conference. Explore a summary of each announcement below.</p>
                </div>
                <div class="hidden sm:flex items-center justify-center rounded-xl bg-white/70 p-3 ring-1 ring-inset ring-indigo-100">
                    <!-- Bell Icon -->
                    <svg class="h-7 w-7 text-indigo-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <path d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6 6 0 10-12 0v3.159c0 .538-.214 1.055-.595 1.436L4 17h5" />
                        <path d="M13.73 21a2 2 0 01-3.46 0" />
                    </svg>
                </div>
            </div>
        </section>

        <!-- Announcement Grid -->
        @if($announcements->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @foreach ($announcements as $announcement)
                    <article class="group relative rounded-xl border border-gray-200 bg-white p-5 shadow-sm transition-all duration-300 hover:-translate-y-0.5 hover:shadow-md">
                        <div class="absolute inset-x-0 -top-px h-px bg-gradient-to-r from-transparent via-indigo-200 to-transparent"></div>
                        <div class="flex items-start gap-4">
                            <div class="mt-1 shrink-0 rounded-lg bg-indigo-50 p-2 text-indigo-600 ring-1 ring-inset ring-indigo-100">
                                <!-- Document Icon -->
                                <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                    <path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8l-6-6z" />
                                    <path d="M14 2v6h6" />
                                </svg>
                            </div>
                            <div class="min-w-0 w-full">
                                <x-scheduledConference::announcement-summary :announcement="$announcement" />
                            </div>
                        </div>

                        <div class="mt-4 flex items-center justify-between text-sm">
                            <span class="inline-flex items-center gap-1.5 text-gray-500 group-hover:text-gray-700 transition-colors">
                                <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                    <path d="M5 12h14" />
                                    <path d="M12 5l7 7-7 7" />
                                </svg>
                                Read More
                            </span>
                            <span class="opacity-0 transition-opacity duration-300 group-hover:opacity-100 text-indigo-600">
                                <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                    <path d="M9 18l6-6-6-6" />
                                </svg>
                            </span>
                        </div>
                    </article>
                @endforeach
            </div>
        @else
            <!-- Empty State -->
            <div class="rounded-2xl border border-dashed border-gray-300 bg-white p-10 text-center shadow-sm">
                <div class="mx-auto mb-3 flex h-12 w-12 items-center justify-center rounded-full bg-gray-50 text-gray-400 ring-1 ring-inset ring-gray-200">
                    <!-- Inbox Icon -->
                    <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <path d="M22 12h-6l-2 3h-4l-2-3H2" />
                        <path d="M5 7h14l2 5v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6l2-5z" />
                    </svg>
                </div>
                <h2 class="text-lg font-semibold text-gray-900">No announcement yet</h2>
                <p class="mt-1 text-gray-500">The announcement will appear here once it has been created.</p>
            </div>
        @endif
    </div>
</x-astronomy::layouts.main>
