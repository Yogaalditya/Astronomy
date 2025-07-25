@php
    $primaryNavigationItems = app()->getNavigationItems('primary-navigation-menu');
    $userNavigationMenu = app()->getNavigationItems('user-navigation-menu');
@endphp

<!-- Top Navigation Bar -->
@if(App\Facades\Plugin::getPlugin('Astronomy')->getSetting('top_navigation'))
<div class="navbar-publisher bg-gradient-to-r text-black top-0 w-full font-semibold z-[60]">
    <!-- Top Row: Logo & User Navigation -->
    <div class="container mx-auto px-4 lg:px-8 h-16 flex items-center justify-between">
        <!-- Logo Section -->
        <div class="flex items-center gap-x-4">
            <x-astronomy::logo
                :headerLogo="app()->getSite()->getFirstMedia('logo')?->getAvailableUrl(['thumb', 'thumb-xl'])"
                :headerLogoAltText="app()->getSite()->getMeta('name')"
                :homeUrl="url('/')"
                class="text-black h-8 w-auto"
            />
        </div>

        <!-- User Navigation -->
        <div class="hidden lg:flex items-center gap-x-6">
            <x-astronomy::navigation-menu
            :items="$userNavigationMenu"
            class="flex items-center gap-x-6 text-white hover:text-gray-200 transition-colors duration-200"
            />
        </div>
    </div>

    <!-- Horizontal Separator -->
    <div class="border-b-2 border-gray-800 opacity-70"></div>

    <!-- Bottom Row: Menu Items -->
    @if(App\Models\Conference::exists())
    <div class="container mx-auto px-4 lg:px-8 py-3">
        <div class="flex justify-start">
            @livewire(App\Livewire\GlobalNavigation::class)
        </div>
    </div>
    @endif
</div>
@endif

@if(app()->getCurrentConference() || app()->getCurrentScheduledConference())
    <div id="navbar" class="sticky-navbar top-0 shadow z-50 w-full text-white transition-all duration-300">
        <!-- Top Row: Logo & User -->
        <div class="navbar-astronomy navbar-custom-astronomy container mx-auto px-4 lg:px-8">
            <div class="flex items-center justify-between h-16">
                <!-- Mobile Menu & Logo -->
                <div class="flex items-center gap-x-6">
                    <div class="lg:hidden">
                        <x-astronomy::navigation-menu-mobile />
                    </div>
                    <x-astronomy::logo
                        :headerLogo="$headerLogo"
                        class="font-bold h-8 w-auto"
                    />
                </div>

                <!-- User Navigation (only if top_navigation is disabled) -->
                @if(!App\Facades\Plugin::getPlugin('Astronomy')->getSetting('top_navigation'))
                <div class="hidden lg:flex justify-end items-center space-x-6 z-10">
                    <x-astronomy::navigation-menu
                    :items="$userNavigationMenu"
                    class="flex items-center gap-x-6 text-white hover:text-gray-200 transition-colors duration-200"
                    />
                </div>
                @endif
            </div>
        </div>

        <!-- Horizontal Separator - Full Width -->
        <div class="border-b-2 border-gray-800 opacity-80 w-full"></div>

        <!-- Bottom Row: Menu Items -->
        <div class="navbar-astronomy navbar-custom-astronomy container mx-auto px-4 lg:px-8">
            <div class="hidden lg:flex justify-start py-4">
                <x-astronomy::navigation-menu
                    :items="$primaryNavigationItems"
                    class="flex items-center gap-x-8 text-white hover:text-gray-200 transition-colors duration-200"
                />
            </div>
        </div>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        var navbar = document.getElementById('navbar');

        function handleScroll() {
            if (window.scrollY > 0) {
                navbar.classList.add('scrolled');
            } else {
                navbar.classList.remove('scrolled');
            }
        }

        window.addEventListener('scroll', handleScroll);
    });
    </script>
@endif
