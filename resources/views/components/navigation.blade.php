<!-- {{-- resources/views/components/top-navbar.blade.php --}} -->
@props([
    'active' => 'dashboard', 
    'user'   => auth()->user(),
])

<nav class="bg-white/90 backdrop-blur-xl border-b border-slate-200/50 sticky top-0 z-50 transition-all duration-300 shadow-sm shadow-indigo-500/5">
    <div class="max-w-[1600px] mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex h-20 items-center justify-between gap-4">
            {{-- Left side: Logo --}}
            <div class="flex-shrink-0 flex items-center">
                <a href="{{ url('/') }}" class="flex items-center gap-3 group">
                    <div class="relative flex h-11 w-11 items-center justify-center rounded-2xl bg-gradient-to-br from-indigo-600 via-indigo-500 to-purple-600 text-white shadow-lg shadow-indigo-500/30 transition-transform duration-300 group-hover:scale-110 group-hover:rotate-3">
                         <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" class="animate-pulse">
                            <path d="M4 10.5C5.2 8 7 7 9 7c2.7 0 3.5 2 5.5 2 1.4 0 2.6-.7 3.5-2.1C17.8 12 16 13 14 13c-2.7 0-3.5-2-5.5-2-1.4 0-2.6.7-3.5 2.1Z" fill="currentColor" />
                        </svg>
                        <div class="absolute inset-0 rounded-2xl ring-1 ring-inset ring-white/20"></div>
                    </div>
                    <div class="hidden lg:flex flex-col">
                        <span class="text-xl font-bold bg-clip-text text-transparent bg-gradient-to-r from-slate-900 to-slate-700 font-display tracking-tight leading-none group-hover:text-indigo-600 transition-colors">TalentBridge</span>
                        <span class="text-[10px] font-semibold text-slate-400 uppercase tracking-widest leading-none mt-1">Plateforme Pro</span>
                    </div>
                </a>
            </div>

            {{-- Center: Main Navigation --}}
            <div class="hidden md:flex flex-1 items-center justify-center">
                <div class="flex items-center justify-center p-1.5 rounded-full bg-slate-100/50 border border-slate-200/50 backdrop-blur-sm">
                    @if($user->role->value == "RECRUTEUR")
                        <x-nav.recruteur :active="$active ?? 'dashboard' "/>
                    @elseif($user->role->value === 'RECHERCHEUR')
                        <x-nav.rechercheur :active="$active ?? 'dashboard' "/>
                    @else
                        <x-nav.rechercheur :active="$active ?? 'dashboard' "/>
                    @endif
                </div>
            </div>

            {{-- Right side: Actions --}}
            <div class="flex items-center justify-end gap-3 sm:gap-5 flex-shrink-0">
                {{-- Search --}}
                <div class="hidden xl:block">
                    <div class="relative group">
                        <input
                            type="text"
                            placeholder="Rechercher..."
                            class="block w-64 rounded-full border-none bg-slate-50 py-2.5 pl-11 pr-4 text-sm text-slate-700 placeholder-slate-400 ring-1 ring-slate-200 transition-all duration-300 focus:w-80 focus:bg-white focus:ring-2 focus:ring-indigo-500/20 focus:shadow-lg focus:shadow-indigo-500/5"
                        />
                        <div class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none">
                            <svg class="h-5 w-5 text-slate-400 group-focus-within:text-indigo-500 transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35M10.5 18a7.5 7.5 0 1 1 0-15 7.5 7.5 0 0 1 0 15z" />
                            </svg>
                        </div>
                    </div>
                </div>

                {{-- Divider --}}
                <div class="h-8 w-px bg-slate-200 hidden sm:block"></div>

                <div class="flex items-center gap-2">
                    {{-- Notifications --}}
                    <a href="{{ route('notifications.index') }}"
                        class="relative flex h-10 w-10 items-center justify-center rounded-full text-slate-500 hover:bg-indigo-50 hover:text-indigo-600 transition-all duration-200 group">
                        <svg class="h-6 w-6 transition-transform group-hover:scale-110" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M15 17h5l-1.4-1.4A2 2 0 0 1 18 14.2V11a6 6 0 1 0-12 0v3.2c0 .5-.2 1-.6 1.4L4 17h5m6 0a3 3 0 1 1-6 0" />
                        </svg>
                        @if(auth()->user()->notifications()->count() > 0)
                            <span class="absolute top-2.5 right-2.5 flex h-2.5 w-2.5">
                                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-red-400 opacity-75"></span>
                                <span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-red-500 border-2 border-white"></span>
                            </span>
                        @endif
                    </a>

                    {{-- Logout --}}
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit"
                            class="flex h-10 w-10 items-center justify-center rounded-full text-slate-500 hover:bg-red-50 hover:text-red-500 transition-all duration-200 group" title="Déconnexion">
                            <svg class="h-6 w-6 transition-transform group-hover:rotate-180" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M17 16l4-4m0 0l-4-4m4 4H9m4 4v1a2 2 0 01-2 2H7a2 2 0 01-2-2V7a2 2 0 012-2h4a2 2 0 012 2v1" />
                            </svg>
                        </button>
                    </form>

                    {{-- Profile --}}
                    <div class="ml-2 pl-2">
                        <a href="{{ route('profile.edit') }}" class="flex items-center gap-3 p-1 rounded-full border border-slate-200 bg-white hover:border-indigo-200 hover:shadow-md hover:shadow-indigo-500/10 transition-all duration-300 pr-4 group">
                            <img class="h-9 w-9 rounded-full object-cover ring-2 ring-white" src="{{ $user?->image ?? 'https://i.pravatar.cc/150?img=3' }}" alt="{{ $user?->name }}">
                            <div class="flex flex-col items-start">
                                <span class="text-sm font-bold text-slate-700 group-hover:text-indigo-700 transition-colors">{{ Str::limit($user->name, 12) }}</span>
                                <span class="text-[10px] font-medium text-slate-400 leading-none">Mon Compte</span>
                            </div>
                            <svg class="h-4 w-4 text-slate-300 group-hover:text-indigo-400 transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</nav>