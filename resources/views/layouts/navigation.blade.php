<nav x-data="{ open: false }" class="bg-white border-b-4 border-emerald-700 shadow-sm sticky top-0 z-40">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}" class="flex items-center group">
                        <img src="{{ asset('images/logo-pnbb.jpg') }}" alt="Logo PN Bale Bandung" class="h-10 w-auto transform group-hover:scale-110 transition-transform">
                        
                        <span class="ml-3 font-black text-emerald-900 uppercase tracking-wider text-sm hidden lg:block">
                            E-Archive <span class="text-amber-600">PNBB</span>
                        </span>
                    </a>
                </div>

                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    @if(auth()->user()->grup != 'admin')
                        <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" class="font-bold uppercase text-xs tracking-widest">
                            {{ __('Dashboard') }}
                        </x-nav-link>
                        
                        <x-nav-link :href="route('arsip.index')" :active="request()->routeIs('arsip.*')" class="font-bold uppercase text-xs tracking-widest">
                            {{ __('Manajemen Arsip') }}
                        </x-nav-link>
                    @else
                        <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" class="font-bold uppercase text-xs tracking-widest">
                            {{ __('Dashboard') }}
                        </x-nav-link>

                        <x-nav-link :href="route('users.index')" :active="request()->routeIs('users.index')" class="font-bold uppercase text-xs tracking-widest">
                            {{ __('Manajemen User') }}
                        </x-nav-link>

                        <x-nav-link :href="route('hak-akses.index')" :active="request()->routeIs('hak-akses.*')" class="font-bold uppercase text-xs tracking-widest">
                            {{ __('Hak Akses') }}
                        </x-nav-link>
                    @endif
                </div>
            </div>

            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-4 py-2 border border-emerald-100 text-sm leading-4 font-bold rounded-xl text-emerald-800 bg-emerald-50/50 hover:bg-emerald-100 hover:text-emerald-900 focus:outline-none transition ease-in-out duration-150">
                            <div class="flex items-center">
                                <div class="w-6 h-6 bg-emerald-700 rounded-full flex items-center justify-center mr-2">
                                    <span class="text-[10px] text-white">{{ substr(Auth::user()->name, 0, 1) }}</span>
                                </div>
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
                        <div class="block px-4 py-2 text-xs text-gray-400 font-bold uppercase tracking-widest border-b border-gray-50">
                            Pengaturan Akun
                        </div>

                        <x-dropdown-link :href="route('profile.edit')" class="font-semibold text-emerald-800">
                            {{ __('Profil Saya') }}
                        </x-dropdown-link>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();"
                                    class="bg-red-50 hover:bg-red-100">
                                <span class="text-red-600 font-black uppercase text-[10px] tracking-widest">{{ __('Keluar Sistem') }}</span>
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-emerald-700 hover:text-emerald-900 hover:bg-emerald-50 focus:outline-none focus:bg-emerald-50 focus:text-emerald-900 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden bg-emerald-50/50">
        <div class="pt-2 pb-3 space-y-1">
            @if(auth()->user()->grup != 'admin')
                <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" class="font-bold">
                    {{ __('Dashboard') }}
                </x-responsive-nav-link>
                
                <x-responsive-nav-link :href="route('arsip.index')" :active="request()->routeIs('arsip.*')" class="font-bold">
                    {{ __('Manajemen Arsip') }}
                </x-responsive-nav-link>
            @else
                <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" class="font-bold">
                    {{ __('Dashboard') }}
                </x-responsive-nav-link>

                <x-responsive-nav-link :href="route('users.index')" :active="request()->routeIs('users.index')" class="font-bold text-blue-700">
                    {{ __('Manajemen User') }}
                </x-responsive-nav-link>

                <x-responsive-nav-link :href="route('hak-akses.index')" :active="request()->routeIs('hak-akses.*')" class="font-bold text-emerald-700">
                    {{ __('Hak Akses') }}
                </x-responsive-nav-link>
            @endif
        </div>

        <div class="pt-4 pb-1 border-t border-emerald-200">
            <div class="px-4">
                <div class="font-black text-base text-emerald-900">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-emerald-600 italic">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">
                    {{ __('Profil') }}
                </x-responsive-nav-link>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault();
                                        this.closest('form').submit();"
                            class="bg-red-50 text-red-600 font-bold">
                        {{ __('Keluar Sistem') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>