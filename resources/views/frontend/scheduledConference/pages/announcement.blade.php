<x-astronomy::layouts.main>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="mb-6">
            <x-astronomy::breadcrumbs :breadcrumbs="$this->getBreadcrumbs()" />
        </div>
      
            <div class="p-3 space-y-6">
                <header class="space-y-2">
                    <h1 class="text-3xl font-extrabold text-gray-900 text-center">{{ $announcement->title }}</h1>
                </header>

                <div class="max-w-3xl mx-auto space-y-4">
                    @if ($announcement->hasMedia('featured_image'))
                        <div class="overflow-hidden rounded-lg">
                            <img class="mx-auto w-full h-auto object-contain"
                                src="{{ $announcement->getFirstMedia('featured_image')->getAvailableUrl(['thumb']) }}"
                                alt="{{ $announcement->title }}">
                        </div>
                    @endif

                    <div class="prose max-w-none text-justify hyphens-auto break-words text-black" lang="{{ app()->getLocale() }}">
                        {{ new Illuminate\Support\HtmlString($this->announcement->getMeta('content')) }}
                    </div>
                </div>
            </div>
       
    </div>
</x-astronomy::layouts.main>