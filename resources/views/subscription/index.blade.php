<x-app-layout>
    <div class="min-h-screen bg-slate-50 font-sans relative overflow-hidden">
        <!-- Background Atmosphere -->
        <div class="absolute top-0 left-1/2 -translate-x-1/2 w-full h-[600px] bg-indigo-900/5 rounded-full blur-3xl pointer-events-none"></div>
        <div class="absolute top-20 right-0 w-[500px] h-[500px] bg-purple-100/40 rounded-full blur-3xl pointer-events-none mix-blend-multiply"></div>
        <div class="absolute bottom-0 left-0 w-[600px] h-[600px] bg-indigo-50/60 rounded-full blur-3xl pointer-events-none mix-blend-multiply"></div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20 relative z-10">
            
            <!-- Header -->
            <div class="text-center max-w-3xl mx-auto mb-20">
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-indigo-50 border border-indigo-100 text-indigo-600 text-xs font-bold uppercase tracking-wider mb-6 animate-in fade-in slide-in-from-bottom-4 duration-700">
                    <span class="w-2 h-2 rounded-full bg-indigo-500 animate-pulse"></span>
                    Plans & Tarifs
                </div>
                <h1 class="text-5xl md:text-6xl font-black text-slate-900 tracking-tight mb-6 animate-in fade-in slide-in-from-bottom-5 duration-700 delay-100">
                    Débloquez votre <span class="text-transparent bg-clip-text bg-gradient-to-r from-indigo-600 to-purple-500">Potentiel</span>
                </h1>
                <p class="text-xl text-slate-500 font-medium leading-relaxed animate-in fade-in slide-in-from-bottom-6 duration-700 delay-200">
                    Des outils puissants pour les chercheurs d'emploi ambitieux et les recruteurs exigeants.
                    <br class="hidden md:block">Simple. Transparent. Sans engagement.
                </p>
            </div>

            @if(auth()->user()->subscribed('default'))
                 <!-- Active Subscription State -->
                <div class="max-w-3xl mx-auto text-center bg-white/80 backdrop-blur-xl rounded-[2.5rem] border border-white shadow-2xl shadow-indigo-100/50 p-12 relative overflow-hidden animate-in zoom-in-95 duration-500">
                    <div class="absolute top-0 left-0 w-full h-2 bg-gradient-to-r from-emerald-400 to-teal-500"></div>
                    
                    <div class="w-24 h-24 bg-emerald-50 rounded-3xl flex items-center justify-center mx-auto mb-8 shadow-sm rotate-3 border border-emerald-100">
                        <svg class="w-12 h-12 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    
                    <h2 class="text-3xl font-black text-slate-900 mb-4">Vous êtes Premium !</h2>
                    <p class="text-lg text-slate-600 mb-10 max-w-lg mx-auto leading-relaxed">
                        Votre abonnement est actif. Profitez d'un accès illimité à toutes les fonctionnalités exclusives de Talentia Pro.
                    </p>

                    <div class="bg-slate-50 rounded-2xl p-8 mb-10 text-left max-w-md mx-auto border border-slate-100 shadow-inner">
                         <div class="flex justify-between items-center mb-4 border-b border-slate-200 pb-4">
                            <span class="text-slate-500 font-medium text-sm">Statut</span>
                            <span class="inline-flex items-center gap-1.5 font-bold text-emerald-600 bg-emerald-100/50 px-3 py-1 rounded-full text-xs box-border border border-emerald-200">
                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                Actif
                            </span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-slate-500 font-medium text-sm">Prochaine facturation</span>
                            <span class="font-bold text-slate-900 text-sm">
                                {{ auth()->user()->subscription('default')->ends_at?->format('d F Y') ?? 'Renouvellement auto' }}
                            </span>
                        </div>
                    </div>
                    
                    <a href="{{ auth()->user()->role === \App\UserRole::RECRUTEUR ? route('dashboard.recruteur') : route('dashboard.rechercheur') }}" 
                       class="inline-flex items-center gap-2 py-4 px-10 bg-slate-900 hover:bg-slate-800 text-white font-bold rounded-2xl transition-all shadow-xl shadow-slate-900/20 hover:scale-105 active:scale-95">
                        Aller au Tableau de bord
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" /></svg>
                    </a>
                </div>
            @else
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 max-w-7xl mx-auto">
                
                <!-- Free Plan -->
                <div class="bg-white/60 backdrop-blur-md rounded-[2rem] border border-white shadow-xl shadow-slate-200/50 p-8 flex flex-col transition-all duration-300 hover:shadow-2xl hover:-translate-y-1 group">
                    <div class="mb-8">
                        <span class="inline-block py-1.5 px-4 rounded-xl bg-slate-100 text-slate-600 text-[11px] font-black uppercase tracking-wider mb-6 group-hover:bg-slate-200 transition-colors">
                            Découverte
                        </span>
                        <div class="flex items-baseline gap-1">
                            <h3 class="text-4xl font-black text-slate-900">Gratuit</h3>
                        </div>
                        <p class="text-slate-500 mt-3 font-medium text-sm">Pour commencer votre recherche.</p>
                    </div>
                    
                    <ul class="space-y-4 mb-8 flex-1">
                        @foreach(['Accès aux offres basiques', 'Profil professionnel', '3 candidatures / mois'] as $feature)
                        <li class="flex items-start gap-3">
                            <div class="mt-0.5 w-5 h-5 rounded-full bg-slate-100 flex items-center justify-center flex-shrink-0 text-slate-500">
                                <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                            </div>
                            <span class="text-slate-600 text-sm font-medium">{{ $feature }}</span>
                        </li>
                        @endforeach
                    </ul>

                    <a href="{{ route('checkout', ['plan' => 'free']) }}" class="block w-full py-4 px-6 bg-white hover:bg-slate-50 text-slate-900 font-bold rounded-2xl text-center transition-all border border-slate-200 shadow-sm hover:shadow-md">
                        Commencer gratuitement
                    </a>
                </div>

                <!-- Pro Plan (Popular) -->
                <div class="bg-white rounded-[2.5rem] border-2 border-indigo-500 shadow-2xl shadow-indigo-200/50 p-8 flex flex-col relative transform md:-translate-y-4 md:scale-105 z-10">
                    <div class="absolute -top-5 left-1/2 -translate-x-1/2 bg-gradient-to-r from-indigo-600 to-purple-600 text-white text-[11px] font-bold px-4 py-1.5 rounded-full uppercase tracking-wider shadow-lg shadow-indigo-500/30 flex items-center gap-1.5">
                        <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" /></svg>
                        Le plus populaire
                    </div>
                    
                    <div class="mb-8 mt-2">
                        <span class="inline-block py-1.5 px-4 rounded-xl bg-indigo-50 text-indigo-600 text-[11px] font-black uppercase tracking-wider mb-6">
                            Professionnel
                        </span>
                        <div class="flex items-baseline gap-1">
                            <span class="text-5xl font-black text-slate-900 tracking-tight">$29</span>
                            <span class="text-slate-400 font-bold">/mois</span>
                        </div>
                        <p class="text-slate-500 mt-3 font-medium text-sm">Tout ce qu'il faut pour réussir.</p>
                    </div>
                    
                    <ul class="space-y-4 mb-8 flex-1">
                         @foreach(['Candidatures Illimitées', 'Badge "Candidat Vedette"', 'Qui a vu mon profil ?', 'Support Prioritaire'] as $feature)
                        <li class="flex items-start gap-3">
                            <div class="mt-0.5 w-5 h-5 rounded-full bg-indigo-100 flex items-center justify-center flex-shrink-0 text-indigo-600">
                                <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                            </div>
                            <span class="text-slate-700 text-sm font-bold">{{ $feature }}</span>
                        </li>
                        @endforeach
                    </ul>

                    <a href="{{ route('checkout', ['plan' => 'pro']) }}" class="block w-full py-4 px-6 bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white font-bold rounded-2xl text-center shadow-xl shadow-indigo-500/30 transition-all hover:scale-[1.02] active:scale-95">
                        Passer à Pro
                    </a>
                </div>

                <!-- Enterprise Plan -->
                  <div class="bg-white/60 backdrop-blur-md rounded-[2rem] border border-white shadow-xl shadow-slate-200/50 p-8 flex flex-col transition-all duration-300 hover:shadow-2xl hover:-translate-y-1 group">
                    <div class="mb-8">
                        <span class="inline-block py-1.5 px-4 rounded-xl bg-blue-50 text-blue-600 text-[11px] font-black uppercase tracking-wider mb-6 group-hover:bg-blue-100 transition-colors">
                            Business
                        </span>
                        <div class="flex items-baseline gap-1">
                            <span class="text-4xl font-black text-slate-900">$99</span>
                            <span class="text-slate-400 font-bold">/mois</span>
                        </div>
                        <p class="text-slate-500 mt-3 font-medium text-sm">Pour les équipes et recruteurs.</p>
                    </div>
                    
                    <ul class="space-y-4 mb-8 flex-1">
                        @foreach(['Publier des offres illimitées', 'Recherche avancée de talents', 'Gestion d\'équipe', 'API Access'] as $feature)
                        <li class="flex items-start gap-3">
                            <div class="mt-0.5 w-5 h-5 rounded-full bg-blue-50 flex items-center justify-center flex-shrink-0 text-blue-500">
                                <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                            </div>
                            <span class="text-slate-600 text-sm font-medium">{{ $feature }}</span>
                        </li>
                        @endforeach
                    </ul>

                    <a href="{{ route('checkout', ['plan' => 'business']) }}" class="block w-full py-4 px-6 bg-white hover:bg-slate-50 text-slate-900 font-bold rounded-2xl text-center transition-all border border-slate-200 shadow-sm hover:shadow-md">
                        Contacter les ventes
                    </a>
                </div>
            </div>
            @endif

            <!-- Trust / Footer -->
            <div class="mt-24 text-center border-t border-slate-100/50 pt-10">
                <p class="text-slate-400 text-xs font-bold uppercase tracking-widest mb-8">Ils nous font confiance</p>
                <div class="flex flex-wrap justify-center items-center gap-8 md:gap-16 opacity-40 grayscale transition-all duration-500 hover:grayscale-0 hover:opacity-100">
                   <!-- Logo Placeholders using Text for elegance -->
                   <span class="text-2xl font-black text-slate-300">Google</span>
                   <span class="text-2xl font-black text-slate-300">Microsoft</span>
                   <span class="text-xl font-black text-slate-300">Spotify</span>
                   <span class="text-2xl font-black text-slate-300">Amazon</span>
                   <span class="text-xl font-black text-slate-300">Airbnb</span>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
