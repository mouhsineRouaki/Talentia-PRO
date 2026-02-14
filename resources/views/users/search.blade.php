<x-app-layout>
    <!-- Background Elements -->
    <div class="fixed inset-0 -z-10 overflow-hidden pointer-events-none">
        <div class="absolute top-0 left-1/4 w-full h-[600px] bg-indigo-50/40 rounded-full blur-3xl opacity-50 mix-blend-multiply"></div>
        <div class="absolute top-0 right-1/4 w-full h-[600px] bg-emerald-50/40 rounded-full blur-3xl opacity-50 mix-blend-multiply"></div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 space-y-12">
        
        <!-- Header & Search Hero -->
        <div class="relative text-center max-w-2xl mx-auto space-y-6">
            <h1 class="text-4xl md:text-5xl font-black tracking-tight text-slate-900">
                Explorez la communauté <br>
                <span class="text-transparent bg-clip-text bg-gradient-to-r from-indigo-600 to-emerald-500">Talentia Pro</span>
            </h1>
            <p class="text-lg text-slate-600">
                Connectez-vous avec des recruteurs et des talents exceptionnels.
            </p>

            <!-- Search Bar Floating -->
            <div class="relative group max-w-lg mx-auto mt-8">
                <div class="absolute -inset-1 bg-gradient-to-r from-indigo-500 to-emerald-500 rounded-[2rem] opacity-25 group-hover:opacity-50 blur transition duration-500"></div>
                <div class="relative bg-white rounded-[1.7rem] p-2 flex items-center shadow-xl ring-1 ring-slate-200/50">
                    <form method="GET" action="{{ url('/search') }}" class="flex-1 flex items-center">
                        <div class="pl-4 text-slate-400">
                            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </div>
                        <input type="text" name="q" value="{{ $q ?? '' }}" 
                               class="w-full border-none bg-transparent px-4 py-3 text-lg placeholder-slate-400 focus:ring-0 text-slate-900 font-medium" 
                               placeholder="Rechercher un membre..." autocomplete="off">
                        
                        @if(!empty($q))
                            <a href="{{ url('/search') }}" class="p-2 mr-1 text-slate-400 hover:text-rose-500 transition-colors rounded-full hover:bg-slate-100" title="Effacer">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </a>
                        @endif

                        <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white rounded-[1.2rem] px-6 py-3 font-bold text-sm shadow-lg shadow-indigo-500/30 transition-all hover:scale-105 active:scale-95">
                            Rechercher
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Results Section -->
        <div>
            <div class="flex items-center justify-between mb-8 px-2">
                <h3 class="text-xl font-bold text-slate-900 flex items-center gap-2">
                    Résultats
                    <span class="inline-flex items-center justify-center bg-slate-100 text-slate-600 text-xs font-bold px-2.5 py-0.5 rounded-full ring-1 ring-slate-200">
                        {{ count($users) }}
                    </span>
                </h3>
                
                {{-- Optional: Add filters button here later --}}
            </div>

            @if(count($users) > 0)
                <div class="grid gap-8 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-3">
                    @foreach($users as $u)
                        <div class="h-full flex flex-col" style="perspective: 1000px">
                             <x-user-card
                                :href="route('users.show', $u->id)"
                                :userId="$u->id"
                                :nom="$u->nom"
                                :prenom="$u->prenom"
                                :role="$u->role"
                                :email="$u->email"
                                :biographie="$u->biographie"
                                :image="$u->image"
                            />
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-20 bg-white/50 backdrop-blur-sm rounded-[3rem] border border-slate-100 dashed border-2">
                    <div class="mx-auto w-24 h-24 bg-slate-50 text-slate-300 rounded-full flex items-center justify-center mb-6">
                        <svg class="w-12 h-12" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-slate-900">Aucun résultat trouvé</h3>
                    <p class="mt-2 text-slate-500 max-w-sm mx-auto">
                        Nous n'avons trouvé aucun membre correspondant à <span class="font-bold text-slate-900">"{{ $q }}"</span>. 
                        Essayez un autre terme.
                    </p>
                    <a href="{{ url('/search') }}" class="inline-flex items-center gap-2 mt-6 px-6 py-3 rounded-2xl bg-white border border-slate-200 text-slate-700 font-bold hover:bg-slate-50 hover:border-slate-300 transition-all shadow-sm">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                        </svg>
                        Tout afficher
                    </a>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
