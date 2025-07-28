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
    <div id="navbar" class="sticky-navbar navbar-locked top-0 shadow z-50 w-full text-white transition-all duration-500 ease-in-out">

        <!-- Top Row: Logo & User -->
        <div class="navbar-astronomy navbar-custom-astronomy container mx-auto px-4 lg:px-8">
            <div class="flex items-center justify-between navbar-top-section transition-all duration-500 ease-in-out h-16">
                <!-- Mobile Menu & Logo -->
                <div class="flex items-center gap-x-6">
                    <div class="lg:hidden">
                        <x-astronomy::navigation-menu-mobile />
                    </div>
                    <x-astronomy::logo
                        :headerLogo="$headerLogo"
                        class="font-bold navbar-logo transition-all duration-500 ease-in-out h-8 w-auto"
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
        <div class="navbar-separator border-b-2 border-gray-800 opacity-80 w-full transition-all duration-500 ease-in-out"></div>

        <!-- Bottom Row: Menu Items -->
        <div class="navbar-astronomy navbar-custom-astronomy container mx-auto px-4 lg:px-8">
            <div class="hidden lg:flex justify-start navbar-menu-section transition-all duration-500 ease-in-out py-4">
                <x-astronomy::navigation-menu
                    :items="$primaryNavigationItems"
                    class="flex items-center gap-x-8 text-white hover:text-gray-200 transition-colors duration-200"
                />
            </div>
        </div>
        
        <!-- Arrow indicator di tengah bawah navbar (hanya untuk desktop) -->
        <!-- <div class="navbar-arrow-indicator hidden lg:flex justify-center items-center w-full pb-2 transition-all duration-300">
            <div class="navbar-arrow-container bg-white bg-opacity-20 backdrop-blur-sm rounded-full p-2 shadow-lg border border-white border-opacity-30 hover:bg-opacity-30 transition-all duration-300">
                <svg class="navbar-arrow-down w-4 h-4 transition-transform duration-300 text-white" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                </svg>
                <svg class="navbar-arrow-up w-4 h-4 transition-transform duration-300 text-white hidden" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M14.707 12.707a1 1 0 01-1.414 0L10 9.414l-3.293 3.293a1 1 0 01-1.414-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 010 1.414z" clip-rule="evenodd"></path>
                </svg>
            </div>
        </div> -->
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const navbar = document.getElementById('navbar');
        const scrollThreshold = 100;
        let hoverTimeout;
        let isHovered = false;
        
        // Arrow elements
        const arrowIndicator = navbar.querySelector('.navbar-arrow-indicator');
        const arrowDown = navbar.querySelector('.navbar-arrow-down');
        const arrowUp = navbar.querySelector('.navbar-arrow-up');

        function updateArrowVisibility() {
            const isMobile = window.innerWidth <= 1024;
            const isMinimized = navbar.classList.contains('navbar-minimized');
            
            if (arrowIndicator) {
                if (isMobile || !isMinimized) {
                    arrowIndicator.style.display = 'none';
                } else {
                    arrowIndicator.style.display = 'flex';
                }
            }
        }

        function showArrowDown() {
            if (arrowDown && arrowUp) {
                arrowDown.classList.remove('hidden');
                arrowUp.classList.add('hidden');
            }
        }

        function showArrowUp() {
            if (arrowDown && arrowUp) {
                arrowDown.classList.add('hidden');
                arrowUp.classList.remove('hidden');
            }
        }

        function handleScroll() {
            if (window.scrollY > scrollThreshold) {
                navbar.classList.add('navbar-minimized');
                showArrowDown();
            } else {
                navbar.classList.remove('navbar-minimized');
                // Reset hover state when not minimized
                navbar.classList.remove('navbar-hover-active');
                clearTimeout(hoverTimeout);
                isHovered = false;
                showArrowDown();
            }
            updateArrowVisibility();
        }

        // Handle mouse enter with delay (hanya untuk desktop)
        navbar.addEventListener('mouseenter', function() {
            // Hanya aktif jika bukan mobile (sidebar menu tidak terlihat)
            const isMobile = window.innerWidth <= 1024;
            if (navbar.classList.contains('navbar-minimized') && !isHovered && !isMobile) {
                isHovered = true;
                hoverTimeout = setTimeout(function() {
                    navbar.classList.add('navbar-hover-active');
                    showArrowUp();
                }, 200);
            }
        });

        // Handle mouse leave
        navbar.addEventListener('mouseleave', function() {
            isHovered = false;
            clearTimeout(hoverTimeout);
            navbar.classList.remove('navbar-hover-active');
            if (navbar.classList.contains('navbar-minimized')) {
                showArrowDown();
            }
        });

        // Handle arrow click untuk feedback visual
        if (arrowIndicator) {
            arrowIndicator.addEventListener('click', function() {
                const arrowContainer = arrowIndicator.querySelector('.navbar-arrow-container');
                if (arrowContainer) {
                    arrowContainer.style.transform = 'scale(0.95)';
                    setTimeout(() => {
                        arrowContainer.style.transform = '';
                    }, 150);
                }
            });
        }

        // Handle window resize
        window.addEventListener('resize', function() {
            updateArrowVisibility();
        });

        window.addEventListener('scroll', handleScroll);
        
        // Initial check
        handleScroll();
        updateArrowVisibility();
    });
    </script>
@endif
