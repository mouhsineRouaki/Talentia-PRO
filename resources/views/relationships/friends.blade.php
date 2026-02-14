<x-app-layout>
    {{-- Background Atmosphere --}}
    <div class="fixed inset-0 -z-10 overflow-hidden pointer-events-none">
        <div class="absolute top-0 left-1/4 w-full h-[600px] bg-indigo-50/40 rounded-full blur-3xl opacity-50 mix-blend-multiply"></div>
        <div class="absolute top-0 right-1/4 w-full h-[600px] bg-pink-50/40 rounded-full blur-3xl opacity-50 mix-blend-multiply"></div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 space-y-8" x-data="{ tab: 'amis' }">
        
        {{-- Header Section --}}
        <div class="relative text-center max-w-2xl mx-auto space-y-4">
            <h1 class="text-4xl md:text-5xl font-black tracking-tight text-slate-900">
                Vos <span class="text-transparent bg-clip-text bg-gradient-to-r from-indigo-600 to-pink-500">Connexions</span>
            </h1>
            <p class="text-lg text-slate-600">
                Gérez vos amis et vos demandes en un clin d'œil.
            </p>

            {{-- Navigation Tabs --}}
            <div class="inline-flex items-center justify-center p-1.5 bg-white/60 backdrop-blur-md border border-slate-200/60 rounded-2xl shadow-sm mt-6">
                
                <button @click="tab = 'amis'" 
                        :class="tab === 'amis' ? 'bg-white text-slate-900 shadow-sm ring-1 ring-slate-200' : 'text-slate-500 hover:text-slate-700 hover:bg-slate-100/50'"
                        class="px-6 py-2.5 rounded-xl text-sm font-bold transition-all duration-200 flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" /></svg>
                    Mes Amis
                    <span class="inline-flex items-center justify-center bg-slate-100 text-slate-600 text-[10px] font-black h-5 min-w-[1.25rem] px-1 rounded-full ms-1">{{ count($friends) }}</span>
                </button>

                <button @click="tab = 'recus'" 
                        :class="tab === 'recus' ? 'bg-white text-slate-900 shadow-sm ring-1 ring-slate-200' : 'text-slate-500 hover:text-slate-700 hover:bg-slate-100/50'"
                        class="px-6 py-2.5 rounded-xl text-sm font-bold transition-all duration-200 flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3" /></svg>
                    Reçues
                    @if(count($received) > 0)
                        <span class="inline-flex items-center justify-center bg-rose-500 text-white text-[10px] font-black h-5 min-w-[1.25rem] px-1 rounded-full ms-1 animate-pulse">{{ count($received) }}</span>
                    @else
                        <span class="inline-flex items-center justify-center bg-slate-100 text-slate-600 text-[10px] font-black h-5 min-w-[1.25rem] px-1 rounded-full ms-1">{{ count($received) }}</span>
                    @endif
                </button>

                <button @click="tab = 'envoyes'" 
                        :class="tab === 'envoyes' ? 'bg-white text-slate-900 shadow-sm ring-1 ring-slate-200' : 'text-slate-500 hover:text-slate-700 hover:bg-slate-100/50'"
                        class="px-6 py-2.5 rounded-xl text-sm font-bold transition-all duration-200 flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6" /></svg>
                    Envoyées
                    <span class="inline-flex items-center justify-center bg-slate-100 text-slate-600 text-[10px] font-black h-5 min-w-[1.25rem] px-1 rounded-full ms-1">{{ count($sent) }}</span>
                </button>

            </div>
             <div class="mt-4">
                 <a href="{{ route('users.search') }}" class="text-xs font-bold text-indigo-600 hover:text-indigo-700 hover:underline">
                    + Trouver de nouveaux profils
                </a>
            </div>
        </div>

        {{-- Main Grid --}}
        <div>
            {{-- AMIS --}}
            <div x-show="tab === 'amis'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0">
                 @if(count($friends) > 0)
                    <div class="grid gap-8 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-3">
                        @foreach($friends as $u)
                            <x-invitation-card
                                :href="route('users.show', $u->id)"
                                :userId="$u->id"
                                :nom="$u->nom"
                                :prenom="$u->prenom"
                                :role="$u->role"
                                :email="$u->email"
                                :biographie="$u->biographie"
                                :image="$u->image"
                                :dejaAmi="true"
                                :isSender="false"
                            />
                        @endforeach
                    </div>
                @else
                    <div class="flex flex-col items-center justify-center py-20 text-center">
                        <div class="w-20 h-20 bg-slate-100 rounded-full flex items-center justify-center mb-4">
                            <svg class="w-10 h-10 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" /></svg>
                        </div>
                        <h3 class="text-xl font-bold text-slate-800">Pas encore d'amis</h3>
                        <p class="text-slate-500 mt-1">Commencez par rechercher des profils intéressants.</p>
                        <a href="{{ route('users.search') }}" class="mt-4 px-6 py-2.5 bg-indigo-600 text-white rounded-xl font-bold text-sm hover:bg-indigo-700 transition">Chercher des profils</a>
                    </div>
                @endif
            </div>

            {{-- RECUS --}}
            <div x-show="tab === 'recus'" x-cloak x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0">
                @if(count($received) > 0)
                    <div class="grid gap-8 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-3">
                        @foreach($received as $u)
                            <x-invitation-card
                                :href="route('users.show', $u->id)"
                                :userId="$u->id"
                                :nom="$u->nom"
                                :prenom="$u->prenom"
                                :role="$u->role"
                                :email="$u->email"
                                :biographie="$u->biographie"
                                :image="$u->image"
                                :dejaAmi="false"
                                :isSender="false"
                            />
                        @endforeach
                    </div>
                @else
                     <div class="flex flex-col items-center justify-center py-20 text-center">
                        <div class="w-20 h-20 bg-slate-100 rounded-full flex items-center justify-center mb-4">
                            <svg class="w-10 h-10 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" /></svg>
                        </div>
                        <h3 class="text-xl font-bold text-slate-800">Aucune demande reçue</h3>
                        <p class="text-slate-500 mt-1">Tout est calme pour le moment.</p>
                    </div>
                @endif
            </div>

            {{-- ENVOYES --}}
            <div x-show="tab === 'envoyes'" x-cloak x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0">
                 @if(count($sent) > 0)
                    <div class="grid gap-8 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-3">
                        @foreach($sent as $u)
                            <x-invitation-card
                                :href="route('users.show', $u->id)"
                                :userId="$u->id"
                                :nom="$u->nom"
                                :prenom="$u->prenom"
                                :role="$u->role"
                                :email="$u->email"
                                :biographie="$u->biographie"
                                :image="$u->image"
                                :dejaAmi="false"
                                :isSender="true"
                            />
                        @endforeach
                    </div>
                @else
                    <div class="flex flex-col items-center justify-center py-20 text-center">
                        <div class="w-20 h-20 bg-slate-100 rounded-full flex items-center justify-center mb-4">
                            <svg class="w-10 h-10 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" /></svg>
                        </div>
                        <h3 class="text-xl font-bold text-slate-800">Aucune invitation envoyée</h3>
                        <p class="text-slate-500 mt-1">Vous n'avez pas de demandes en attente.</p>
                    </div>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>
