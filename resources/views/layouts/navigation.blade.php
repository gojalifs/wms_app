<nav x-data="{ open: false }" class="border-b border-gray-100 relative overflow-hidden" style="background: linear-gradient(135deg, #92f7f6 0%, #a3f0dc 40%, #a3f0dc 70%, #f5f3ff 100%);">
    <!-- Decorative Background Ornaments -->
    <div class="absolute inset-0 pointer-events-none overflow-hidden" aria-hidden="true">
        <!-- Large soft circle - top left -->
        <svg class="absolute -top-10 -left-10 w-40 h-40 opacity-[0.12]" viewBox="0 0 160 160" fill="none">
            <circle cx="80" cy="80" r="80" fill="url(#grad1)"/>
            <defs>
                <radialGradient id="grad1" cx="50%" cy="50%" r="50%">
                    <stop offset="0%" stop-color="#6366f1"/>
                    <stop offset="100%" stop-color="#818cf8" stop-opacity="0"/>
                </radialGradient>
            </defs>
        </svg>
        <!-- Medium circle - top right area -->
        <svg class="absolute -top-6 right-20 w-28 h-28 opacity-[0.10]" viewBox="0 0 112 112" fill="none">
            <circle cx="56" cy="56" r="56" fill="url(#grad2)"/>
            <defs>
                <radialGradient id="grad2" cx="50%" cy="50%" r="50%">
                    <stop offset="0%" stop-color="#0ea5e9"/>
                    <stop offset="100%" stop-color="#38bdf8" stop-opacity="0"/>
                </radialGradient>
            </defs>
        </svg>
        <!-- Small accent circle - center right -->
        <svg class="absolute top-2 right-1/3 w-16 h-16 opacity-[0.08]" viewBox="0 0 64 64" fill="none">
            <circle cx="32" cy="32" r="32" fill="#a78bfa"/>
        </svg>
        <!-- Tiny dot cluster - left area -->
        <svg class="absolute bottom-1 left-1/4 w-24 h-12 opacity-[0.07]" viewBox="0 0 96 48" fill="none">
            <circle cx="12" cy="24" r="6" fill="#6366f1"/>
            <circle cx="36" cy="16" r="4" fill="#818cf8"/>
            <circle cx="56" cy="30" r="5" fill="#a78bfa"/>
            <circle cx="78" cy="20" r="3" fill="#c4b5fd"/>
        </svg>
        <!-- Abstract wavy line accent -->
        <svg class="absolute top-1/2 -translate-y-1/2 left-0 w-full h-8 opacity-[0.04]" viewBox="0 0 1200 32" fill="none" preserveAspectRatio="none">
            <path d="M0 16C100 4 200 28 300 16C400 4 500 28 600 16C700 4 800 28 900 16C1000 4 1100 28 1200 16" stroke="#6366f1" stroke-width="2" fill="none"/>
            <path d="M0 20C100 8 200 32 300 20C400 8 500 32 600 20C700 8 800 32 900 20C1000 8 1100 32 1200 20" stroke="#0ea5e9" stroke-width="1.5" fill="none"/>
        </svg>
        <!-- Soft blob - bottom right -->
        <svg class="absolute -bottom-8 -right-6 w-32 h-32 opacity-[0.09]" viewBox="0 0 128 128" fill="none">
            <ellipse cx="64" cy="64" rx="60" ry="50" transform="rotate(-15 64 64)" fill="url(#grad3)"/>
            <defs>
                <radialGradient id="grad3" cx="50%" cy="50%" r="50%">
                    <stop offset="0%" stop-color="#8b5cf6"/>
                    <stop offset="100%" stop-color="#c4b5fd" stop-opacity="0"/>
                </radialGradient>
            </defs>
        </svg>
    </div>

    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}">
                        <x-application-logo class="block h-9 w-auto fill-current text-gray-800" />
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                        {{ __('wms.nav.dashboard') }}
                    </x-nav-link>
                    <x-nav-link :href="route('materials.index')" :active="request()->routeIs('materials.*')">
                        {{ __('wms.nav.materials') }}
                    </x-nav-link>
                    <x-nav-link :href="route('inventory.index')" :active="request()->routeIs('inventory.*')">
                        {{ __('wms.nav.inventory') }}
                    </x-nav-link>
                    <x-nav-link :href="route('intake.index')" :active="request()->routeIs('intake.*')">
                        {{ __('wms.nav.intake') }}
                    </x-nav-link>
                    <x-nav-link :href="route('outgoing.index')" :active="request()->routeIs('outgoing.*')">
                        {{ __('wms.nav.outgoing') }}
                    </x-nav-link>
                    @if (auth()->user()->isAdmin())
                        <x-nav-link :href="route('categories.index')" :active="request()->routeIs('categories.*')">
                            {{ __('wms.nav.categories') }}
                        </x-nav-link>
                        <x-nav-link :href="route('reports.index')" :active="request()->routeIs('reports.*')">
                            {{ __('wms.nav.reports') }}
                        </x-nav-link>
                        <x-nav-link :href="route('users.index')" :active="request()->routeIs('users.*')">
                            {{ __('wms.nav.users') }}
                        </x-nav-link>
                    @endif
                </div>
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white/70 backdrop-blur-sm hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                            <div>{{ Auth::user()->name }}</div>

                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            {{ __('wms.nav.profile') }}
                        </x-dropdown-link>

                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                {{ __('wms.nav.logout') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                {{ __('wms.nav.dashboard') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('materials.index')" :active="request()->routeIs('materials.*')">
                {{ __('wms.nav.materials') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('inventory.index')" :active="request()->routeIs('inventory.*')">
                {{ __('wms.nav.inventory') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('intake.index')" :active="request()->routeIs('intake.*')">
                {{ __('wms.nav.intake') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('outgoing.index')" :active="request()->routeIs('outgoing.*')">
                {{ __('wms.nav.outgoing') }}
            </x-responsive-nav-link>
            @if (auth()->user()->isAdmin())
                <x-responsive-nav-link :href="route('categories.index')" :active="request()->routeIs('categories.*')">
                    {{ __('wms.nav.categories') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('reports.index')" :active="request()->routeIs('reports.*')">
                    {{ __('wms.nav.reports') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('users.index')" :active="request()->routeIs('users.*')">
                    {{ __('wms.nav.users') }}
                </x-responsive-nav-link>
            @endif
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200">
            <div class="px-4">
                <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">
                    {{ __('wms.nav.profile') }}
                </x-responsive-nav-link>

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        {{ __('wms.nav.logout') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>
