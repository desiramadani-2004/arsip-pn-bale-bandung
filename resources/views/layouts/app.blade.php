<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'E-Archive PNBB') }}</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800,900&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased text-gray-900">
        <div class="min-h-screen flex flex-col bg-gray-50">
            
            @include('layouts.navigation')

            <div class="flex flex-1 overflow-hidden">
                
                @if(auth()->check() && strtolower(auth()->user()->grup) == 'admin')
                    <aside class="w-64 bg-emerald-900 text-white flex-shrink-0 hidden lg:flex flex-col shadow-xl z-10 border-t border-emerald-800">
                        <div class="p-4 border-b border-emerald-800/50 bg-emerald-950/30">
                            <h2 class="text-[11px] font-black uppercase tracking-widest text-emerald-300">Menu Administrator</h2>
                        </div>
                        
                        <nav class="flex-1 p-4 space-y-2 overflow-y-auto">
                            <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 {{ request()->routeIs('dashboard') ? 'bg-emerald-700 text-white font-bold shadow-md' : 'text-emerald-100 hover:bg-emerald-800 hover:text-white' }}">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
                                <span class="text-sm">Dashboard</span>
                            </a>
                            
                            <a href="{{ route('users.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 {{ request()->routeIs('users.*') ? 'bg-emerald-700 text-white font-bold shadow-md' : 'text-emerald-100 hover:bg-emerald-800 hover:text-white' }}">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                                <span class="text-sm">Manajemen User</span>
                            </a>

                            <a href="{{ route('hak-akses.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 {{ request()->routeIs('hak-akses.*') ? 'bg-emerald-700 text-white font-bold shadow-md' : 'text-emerald-100 hover:bg-emerald-800 hover:text-white' }}">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"></path></svg>
                                <span class="text-sm">Manajemen Hak Akses</span>
                            </a>
                        </nav>
                        
                        <div class="p-4 border-t border-emerald-800/50 text-center">
                            <span class="text-[10px] text-emerald-400/70 font-medium tracking-wider">&copy; SUPPORT BY DIGITECH UNIVERSITY</span>
                        </div>
                    </aside>
                @endif

                <div class="flex-1 flex flex-col w-full overflow-hidden">
                    
                    @if (isset($header))
                        <header class="bg-white shadow border-b border-gray-100">
                            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                                {{ $header }}
                            </div>
                        </header>
                    @endif

                    <main class="flex-1 overflow-y-auto">
                        {{ $slot }}
                    </main>
                </div>

            </div>
        </div>
    </body>
</html>