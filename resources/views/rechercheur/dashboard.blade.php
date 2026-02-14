<x-app-layout>
    <x-slot name="header">
        <div class="relative overflow-hidden rounded-3xl bg-indigo-900 px-6 py-10 shadow-xl sm:px-12 sm:py-16">
            <div class="absolute inset-0">
                <img src="https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?ixlib=rb-4.0.3&auto=format&fit=crop&w=2830&q=80&blend=1e1b4b&sat=-100&blend-mode=multiply" alt="" class="h-full w-full object-cover">
            </div>
            <div class="absolute inset-0 bg-gradient-to-r from-purple-900 via-indigo-900/90 to-transparent"></div>
            <div class="relative max-w-2xl">
                @php
                    $u = Auth::user();
                    $full = trim(($u->prenom ?? '') . ' ' . ($u->nom ?? ($u->name ?? 'Chercheur')));
                @endphp
                <div class="flex items-center gap-3">
                    <span class="inline-flex items-center rounded-full bg-purple-500/10 px-3 py-1 text-xs font-medium text-purple-200 ring-1 ring-inset ring-purple-500/20">
                        Espace Candidat
                    </span>
                    <span class="text-sm text-indigo-200">{{ now()->format('d M Y') }}</span>
                </div>
                <h2 class="mt-4 text-3xl font-bold tracking-tight text-white sm:text-4xl">
                    Prêt pour votre prochain défi, {{ $full }} ? 🚀
                </h2>
                <p class="mt-4 text-lg text-indigo-200">
                    Des centaines d'offres vous attendent. Mettez votre profil en avant dès maintenant.
                </p>
                <div class="mt-8 flex gap-4">
                    <a href="{{ route('offers.rechercheurs.index') }}" class="rounded-full bg-white px-5 py-3 text-sm font-semibold text-indigo-900 shadow-sm hover:bg-indigo-50 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-white transition-all duration-300">
                        💼 Voir les offres
                    </a>
                    <a href="{{ url('/profile/manage') }}" class="rounded-full bg-purple-600 px-5 py-3 text-sm font-semibold text-white shadow-sm hover:bg-purple-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-purple-600 transition-all duration-300">
                        ✏️ Mettre à jour mon CV
                    </a>
                </div>
            </div>
        </div>
    </x-slot>

    @php
        $stats = [
            ['label' => 'Candidatures envoyées', 'value' => '8', 'icon' => 'M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z', 'color' => 'indigo', 'change' => '+2'],
            ['label' => 'Entretiens', 'value' => '1', 'icon' => 'M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z', 'color' => 'green', 'change' => 'Cette semaine'],
            ['label' => 'Vues du profil', 'value' => '45', 'icon' => 'M15 12a3 3 0 11-6 0 3 3 0 016 0z M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z', 'color' => 'amber', 'change' => '+15%'],
            ['label' => 'Favoris', 'value' => '12', 'icon' => 'M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z', 'color' => 'pink', 'change' => 'Saved'],
        ];

        $quickActions = [
            [
                'title' => 'Recherche Avancée',
                'desc' => 'Filtrer par ville, salaire...',
                'href' => url('/search'),
                'icon' => 'M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z',
                'color' => 'indigo'
            ],
            [
                'title' => 'Mon Réseau',
                'desc' => 'Gérer mes amis et contacts.',
                'href' => url('/relationships'),
                'icon' => 'M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z',
                'color' => 'blue'
            ],
            [
                'title' => 'Mes Documents',
                'desc' => 'CV, Lettres de motivation.',
                'href' => '#', 
                'icon' => 'M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z',
                'color' => 'slate'
            ],
             [
                'title' => 'Paramètres',
                'desc' => 'Confidentialité et compte.',
                'href' => url('/profile/manage'),
                'icon' => 'M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z',
                'color' => 'slate'
            ],
        ];

        
        $jobSuggestions = [
            [
                'title' => 'Développeur Fullstack React/Laravel',
                'company' => 'TechNova Startups',
                'location' => 'Casablanca, Maroc',
                'type' => 'CDI',
                'tags' => ['Télétravail', 'Urgent'],
                'logo' => 'https://ui-avatars.com/api/?name=Tech+Nova&background=6366f1&color=fff',
                'posted' => 'Il y a 2j'
            ],
            [
                'title' => 'UX Designer Senior',
                'company' => 'Creative Agency',
                'location' => 'Rabat, Maroc',
                'type' => 'Freelance',
                'tags' => ['Design System', 'Figma'],
                'logo' => 'https://ui-avatars.com/api/?name=Creative+Agency&background=10b981&color=fff',
                'posted' => 'Il y a 5h'
            ],
             [
                'title' => 'Product Manager',
                'company' => 'Atlas Digital',
                'location' => 'Marrakech, Maroc',
                'type' => 'CDI',
                'tags' => ['Agile', 'English'],
                'logo' => 'https://ui-avatars.com/api/?name=Atlas+Digital&background=f59e0b&color=fff',
                'posted' => 'Aujourd\'hui'
            ],
        ];
    @endphp

    <div class="mt-8 space-y-10">
        <!-- Stats Grid -->
        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4">
            @foreach($stats as $stat)
                <div class="relative overflow-hidden rounded-2xl bg-white p-6 shadow-sm ring-1 ring-slate-900/5 transition-all hover:-translate-y-1 hover:shadow-md">
                    <dt>
                        <div class="absolute rounded-xl bg-{{ $stat['color'] }}-50 p-3">
                            <svg class="h-6 w-6 text-{{ $stat['color'] }}-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="{{ $stat['icon'] }}" />
                            </svg>
                        </div>
                        <p class="ml-16 truncate text-sm font-medium text-slate-500">{{ $stat['label'] }}</p>
                    </dt>
                    <dd class="ml-16 flex items-baseline pb-1 sm:pb-2">
                        <p class="text-2xl font-semibold text-slate-900">{{ $stat['value'] }}</p>
                        <p class="ml-2 flex items-baseline text-sm font-semibold text-{{ Str::startsWith($stat['change'], '+') ? 'green' : (Str::startsWith($stat['change'], '-') ? 'red' : 'slate') }}-600">
                            {{ $stat['change'] }}
                        </p>
                    </dd>
                </div>
            @endforeach
        </div>

        <div class="grid grid-cols-1 gap-8 lg:grid-cols-3">
            <!-- Main Content (2/3) -->
            <div class="lg:col-span-2 space-y-8">
                <!-- Actions Rapides -->
                <div>
                     <h3 class="text-lg font-bold text-slate-900 mb-4 flex items-center gap-2">
                        <span class="h-2 w-2 rounded-full bg-purple-500"></span>
                        Accès Rapide
                    </h3>
                     <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                        @foreach($quickActions as $action)
                            <a href="{{ $action['href'] }}" class="group relative flex items-center gap-x-6 rounded-2xl bg-white p-4 shadow-sm ring-1 ring-slate-900/5 hover:ring-indigo-500 transition-all">
                                <div class="flex h-12 w-12 flex-none items-center justify-center rounded-xl bg-{{ $action['color'] }}-50 group-hover:bg-indigo-50 transition-colors">
                                    <svg class="h-6 w-6 text-{{ $action['color'] }}-600 group-hover:text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="{{ $action['icon'] }}" />
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="text-base font-semibold leading-7 tracking-tight text-slate-900">{{ $action['title'] }}</h3>
                                    <p class="text-sm leading-6 text-slate-600">{{ $action['desc'] }}</p>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>

                <!-- Job Suggestions -->
                <div class="rounded-3xl bg-white p-8 shadow-sm ring-1 ring-slate-900/5">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-lg font-bold text-slate-900">Offres recommandées pour vous</h3>
                        <a href="{{ route('offers.rechercheurs.index') }}" class="text-sm font-semibold text-indigo-600 hover:text-indigo-500">Voir tout</a>
                    </div>
                    <div class="space-y-4">
                        @foreach($jobSuggestions as $job)
                            <div class="group relative flex flex-col sm:flex-row gap-4 rounded-2xl bg-slate-50 p-4 hover:bg-white hover:shadow-md transition-all duration-300 ring-1 ring-slate-200/50 hover:ring-indigo-100">
                                <img src="{{ $job['logo'] }}" alt="" class="h-14 w-14 rounded-xl object-cover bg-white shadow-sm ring-1 ring-slate-200">
                                <div class="flex-1 min-w-0">
                                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2">
                                        <h4 class="text-base font-bold text-slate-900 group-hover:text-indigo-600 transition-colors">{{ $job['title'] }}</h4>
                                        <span class="inline-flex items-center rounded-full bg-slate-100 px-2 py-1 text-xs font-medium text-slate-600">{{ $job['posted'] }}</span>
                                    </div>
                                    <p class="text-sm text-slate-600 font-medium">{{ $job['company'] }} • {{ $job['location'] }}</p>
                                    <div class="mt-2 flex flex-wrap gap-2">
                                        <span class="inline-flex items-center rounded-md bg-indigo-50 px-2 py-1 text-xs font-medium text-indigo-700 ring-1 ring-inset ring-indigo-700/10">{{ $job['type'] }}</span>
                                        @foreach($job['tags'] as $tag)
                                            <span class="inline-flex items-center rounded-md bg-slate-100 px-2 py-1 text-xs font-medium text-slate-600 ring-1 ring-inset ring-slate-500/10">{{ $tag }}</span>
                                        @endforeach
                                    </div>
                                </div>
                                <div class="sm:self-center">
                                    <a href="#" class="flex w-full sm:w-auto items-center justify-center rounded-xl bg-white px-4 py-2 text-sm font-semibold text-indigo-600 shadow-sm ring-1 ring-inset ring-indigo-200 hover:bg-indigo-50">Postuler</a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Right Sidebar -->
            <div class="space-y-8">
                <!-- Profile Completion -->
                 <div class="rounded-3xl bg-white p-6 shadow-sm ring-1 ring-slate-900/5">
                    <h3 class="text-base font-semibold text-slate-900 mb-2">Complétude du profil</h3>
                    <div class="relative pt-1">
                        <div class="flex mb-2 items-center justify-between">
                            <div>
                                <span class="text-xs font-semibold inline-block py-1 px-2 uppercase rounded-full text-indigo-600 bg-indigo-200">
                                    En cours
                                </span>
                            </div>
                            <div class="text-right">
                                <span class="text-xs font-semibold inline-block text-indigo-600">
                                    70%
                                </span>
                            </div>
                        </div>
                        <div class="overflow-hidden h-2 mb-4 text-xs flex rounded bg-indigo-200">
                            <div style="width:70%" class="shadow-none flex flex-col text-center whitespace-nowrap text-white justify-center bg-indigo-500"></div>
                        </div>
                        <p class="text-xs text-slate-500 mb-4">Ajoutez une certification pour atteindre 80% !</p>
                        <a href="{{ url('/profile/manage') }}" class="text-sm font-semibold text-indigo-600 hover:text-indigo-500 block text-center">Compléter mon profil →</a>
                    </div>
                </div>

                <!-- Premium Promo -->
                @if(!$u->subscribed('default'))
                    <div class="relative overflow-hidden rounded-3xl bg-slate-900 px-6 py-6 shadow-xl">
                        <div class="absolute inset-0 bg-gradient-to-br from-indigo-500 to-purple-600 opacity-90"></div>
                        <div class="relative">
                            <h3 class="text-lg font-bold text-white tracking-tight">Devenez Premium 🌟</h3>
                            <p class="mt-2 text-sm text-indigo-100">Démarquez-vous des autres candidats et accédez aux offres exclusives.</p>
                             <ul class="mt-4 space-y-2 text-sm text-indigo-50">
                                <li class="flex gap-2">
                                    <svg class="h-5 w-5 text-white" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                                    Badge PRO
                                </li>
                                <li class="flex gap-2">
                                    <svg class="h-5 w-5 text-white" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                                    Priorité aux recruteurs
                                </li>
                            </ul>
                            <a href="{{ route('premium') }}" class="mt-6 block w-full rounded-xl bg-white px-3 py-2 text-center text-sm font-semibold text-indigo-600 shadow-sm hover:bg-indigo-50 transition-all">
                                Voir les avantages
                            </a>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
