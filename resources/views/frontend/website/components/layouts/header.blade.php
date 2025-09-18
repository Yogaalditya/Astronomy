@php
    $primaryNavigationItems = app()->getNavigationItems('primary-navigation-menu');
    $userNavigationMenu = app()->getNavigationItems('user-navigation-menu');

    // Determine whether current page is the "home" of the active context
    $isHome = false;
    if ($scheduledConference = app()->getCurrentScheduledConference()) {
        // Scheduled conference homepage
        $isHome = url()->current() === $scheduledConference->getHomeUrl();
    }else {
        // Fallback to site root if no conference context is active
        $isHome = url()->current() === url('/');
    }
@endphp



@if(app()->getCurrentConference() || app()->getCurrentScheduledConference())
    <div id="navbar" class="navbar-text-color sticky-navbar shadow z-50 w-full transition-all duration-500 ease-in-out font-orbitron {{ $isHome ? 'navbar-transparent' : 'navbar-gradient' }}">

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
                            :headerLogo="$headerLogo"
                            :headerLogoAltText="app()->getSite()->getMeta('name')"
                            :homeUrl="url('/')"
                            class="text-[#BFD3E6] h-8 w-auto"
                        />
                    </div>
                </div>

                <!-- Center: Primary Navigation (moved up, centered) -->
                <div class="hidden lg:flex absolute left-1/2 -translate-x-1/2">
                    <x-astronomy::navigation-menu
                        :items="$primaryNavigationItems"
                        class="menu-underline flex items-center gap-x-8 text-[#BFD3E6] hover:text-[#BFD3E6] transition-colors duration-200"
                    />
                </div>

                <!-- Right: User Navigation -->
                <div class="hidden lg:flex justify-end items-center space-x-6 z-10">
                    <x-astronomy::navigation-menu
                        :items="$userNavigationMenu"
                        :avatar="true"
                        class="menu-underline flex items-center gap-x-6 text-[#BFD3E6] hover:text-[#BFD3E6] transition-colors duration-200 "
                    />
                </div>
            </div>
        </div>
    </div>
@endif
