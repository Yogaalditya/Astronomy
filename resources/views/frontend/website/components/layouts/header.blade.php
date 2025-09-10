@php
    $primaryNavigationItems = app()->getNavigationItems('primary-navigation-menu');
    $userNavigationMenu = app()->getNavigationItems('user-navigation-menu');
@endphp

<!-- Top Navigation Bar -->
@if(App\Facades\Plugin::getPlugin('Astronomy')->getSetting('top_navigation'))
<div class="navbar-publisher bg-gradient-to-r text-black top-0 w-full font-semibold z-[60] font-orbitron">
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
            :avatar="true"
            class="menu-underline flex items-center gap-x-6 text-white hover:text-gray-200 transition-colors duration-200"
            />
        </div>
    </div>

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
    <div id="navbar" class="navbar-text-color sticky-navbar shadow z-50 w-full transition-all duration-500 ease-in-out font-orbitron">

        <!-- Top Row: Logo & User -->
        <div class="navbar-astronomy navbar-custom-astronomy-title container mx-auto pl-0 pr-4 lg:pr-8">
            <div class="flex items-center justify-between navbar-top-section h-16 relative"> <!-- JUDULNYA -->
                <!-- Left: Mobile Menu -->
                <div class="flex items-center gap-x-6">
                    <div class="lg:hidden">
                        <x-astronomy::navigation-menu-mobile />
                    </div>
                    <div class="hidden lg:flex items-center gap-x-4">
                        <x-astronomy::logo
                            :headerLogo="app()->getSite()->getFirstMedia('logo')?->getAvailableUrl(['thumb', 'thumb-xl'])"
                            :headerLogoAltText="app()->getSite()->getMeta('name')"
                            :homeUrl="url('/')"
                            class="text-white h-8 w-auto"
                        />
                    </div>
                </div>

                <!-- Center: Primary Navigation (moved up, centered) -->
                <div class="hidden lg:flex absolute left-1/2 -translate-x-1/2">
                    <x-astronomy::navigation-menu
                        :items="$primaryNavigationItems"
                        class="menu-underline flex items-center gap-x-8 text-white hover:text-gray-200 transition-colors duration-200"
                    />
                </div>

                <!-- Right: User Navigation (only if top_navigation is disabled) -->
                @if(!App\Facades\Plugin::getPlugin('Astronomy')->getSetting('top_navigation'))
                <div class="hidden lg:flex justify-end items-center space-x-6 z-10">
                    <x-astronomy::navigation-menu
                        :items="$userNavigationMenu"
                        :avatar="true"
                        class="menu-underline flex items-center gap-x-6 text-white hover:text-gray-200 transition-colors duration-200 "
                    />
                </div>
                @endif
            </div>
        </div>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const navbar = document.getElementById('navbar');
        const scrollThreshold = 100;

        function handleScroll() {
            if (window.scrollY > scrollThreshold) {
                navbar.classList.add('navbar-minimized');
            } else {
                navbar.classList.remove('navbar-minimized');
            }
        }

        window.addEventListener('scroll', handleScroll);
        
        // Initial check
        handleScroll();
    });
    </script>
@endif
