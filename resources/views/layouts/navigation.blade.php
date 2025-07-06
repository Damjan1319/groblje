<nav x-data="{ open: false }" class="bg-white border-b border-gray-100">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('search.index') }}" class="text-xl font-bold text-gray-800">
                        Upravljanje Grobljem
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link :href="route('search.index')" :active="request()->routeIs('search.*')">
                        Početna
                    </x-nav-link>
                    
                    @auth
                        @if(auth()->user()->canEdit())
                            <x-nav-link :href="route('grobno-mesto.index')" :active="request()->routeIs('grobno-mesto.*')">
                                Grobna mesta
                            </x-nav-link>
                            <x-nav-link :href="route('uplatilac.index')" :active="request()->routeIs('uplatilac.*')">
                                Uplatioci
                            </x-nav-link>
                            <x-nav-link :href="route('uplata.index')" :active="request()->routeIs('uplata.*')">
                                Uplate
                            </x-nav-link>
                            <x-nav-link :href="route('statistika.index')" :active="request()->routeIs('statistika.*')">
                                Statistika
                            </x-nav-link>
                        @endif
                    @endauth
                </div>
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                @guest
                    <a href="{{ route('login') }}" class="bg-blue-500 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-medium">
                        Prijava
                    </a>
                @else
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                                <div class="flex items-center">
                                    {{ Auth::user()->name }}
                                </div>

                                <div class="ms-1">
                                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            <div class="px-4 py-2 text-sm text-gray-500">
                                Uloga: {{ ucfirst(auth()->user()->role) }}
                            </div>
                            <x-dropdown-link :href="route('profile.edit')">
                                {{ __('Profile') }}
                            </x-dropdown-link>

                            <!-- Authentication -->
                            <form method="POST" action="{{ route('logout') }}" id="logout-form">
                                @csrf
                                <button type="submit" class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 focus:outline-none">
                                    {{ __('Log Out') }}
                                </button>
                            </form>
                        </x-slot>
                    </x-dropdown>
                @endguest
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
            <x-responsive-nav-link :href="route('search.index')" :active="request()->routeIs('search.*')">
                Početna
            </x-responsive-nav-link>
            
            @auth
                @if(auth()->user()->canEdit())
                    <x-responsive-nav-link :href="route('grobno-mesto.index')" :active="request()->routeIs('grobno-mesto.*')">
                        Grobna mesta
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('uplatilac.index')" :active="request()->routeIs('uplatilac.*')">
                        Uplatioci
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('uplata.index')" :active="request()->routeIs('uplata.*')">
                        Uplate
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('statistika.index')" :active="request()->routeIs('statistika.*')">
                        Statistika
                    </x-responsive-nav-link>
                @endif
            @endauth
        </div>

        <!-- Responsive Settings Options -->
        @guest
            <div class="pt-4 pb-1 border-t border-gray-200">
                <div class="px-4">
                    <a href="{{ route('login') }}" class="bg-blue-500 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-medium block text-center">
                        Prijava
                    </a>
                </div>
            </div>
        @else
            <div class="pt-4 pb-1 border-t border-gray-200">
                <div class="px-4">
                    <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                    <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
                    <div class="font-medium text-sm text-gray-500">Uloga: {{ ucfirst(auth()->user()->role) }}</div>
                </div>

                <div class="mt-3 space-y-1">
                    <x-responsive-nav-link :href="route('profile.edit')">
                        {{ __('Profile') }}
                    </x-responsive-nav-link>

                    <!-- Authentication -->
                    <form method="POST" action="{{ route('logout') }}" id="logout-form-mobile">
                        @csrf
                        <button type="submit" class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 focus:outline-none">
                            {{ __('Log Out') }}
                        </button>
                    </form>
                </div>
            </div>
        @endguest
    </div>
</nav>
