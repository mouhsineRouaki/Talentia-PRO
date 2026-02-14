<x-app-layout>
    <x-slot name="header">
        <div class="relative overflow-hidden rounded-3xl bg-indigo-900 px-6 py-10 shadow-xl sm:px-12 sm:py-16">
            <div class="absolute inset-0">
                <img src="https://images.unsplash.com/photo-1521737604893-d14cc237f11d?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=2830&q=80&blend=1e1b4b&sat=-100&blend-mode=multiply" alt="" class="h-full w-full object-cover">
            </div>
            <div class="absolute inset-0 bg-gradient-to-r from-indigo-900 via-indigo-900/90 to-transparent"></div>
            <div class="relative max-w-2xl">
                @php
                    $u = Auth::user();
                    $full = trim(($u->prenom ?? '') . ' ' . ($u->nom ?? ($u->name ?? 'Recruteur')));
                @endphp
                <div class="flex items-center gap-3">
                    <span class="inline-flex items-center rounded-full bg-indigo-500/10 px-3 py-1 text-xs font-medium text-indigo-200 ring-1 ring-inset ring-indigo-500/20">
                        Espace Recruteur
                    </span>
                    <span class="text-sm text-indigo-200">{{ now()->format('d M Y') }}</span>
                </div>
                <h2 class="mt-4 text-3xl font-bold tracking-tight text-white sm:text-4xl">
                    Bonjour, {{ $full }} ! 👋
                </h2>
                <p class="mt-4 text-lg text-indigo-200">
                    Prêt à dénicher les meilleurs talents aujourd'hui ? Votre tableau de bord est prêt.
                </p>
                <div class="mt-8 flex gap-4">
                    <a href="{{ url('/search') }}" class="rounded-full bg-white px-5 py-3 text-sm font-semibold text-indigo-900 shadow-sm hover:bg-indigo-50 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-white transition-all duration-300">
                        🔍 Trouver un talent
                    </a>
                    <a href="{{ url('/offers/create') }}" class="rounded-full bg-indigo-600 px-5 py-3 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 transition-all duration-300">
                        ＋ Publier une offre
                    </a>
                </div>
            </div>
        </div>
    </x-slot>

    @php
        $stats = [
            ['label' => 'Candidatures reçues', 'value' => '24', 'icon' => 'M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z', 'color' => 'indigo', 'change' => '+12%'],
            ['label' => 'Offres actives', 'value' => '3', 'icon' => 'M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z', 'color' => 'blue', 'change' => 'Stable'],
            ['label' => 'Vues du profil', 'value' => '142', 'icon' => 'M15 12a3 3 0 11-6 0 3 3 0 016 0z M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z', 'color' => 'emerald', 'change' => '+28%'],
            ['label' => 'Messages non lus', 'value' => '5', 'icon' => 'M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z', 'color' => 'amber', 'change' => '-2'],
        ];

        $suggestions = [
             [
                'id' => 1,
                'nom' => 'Benali',
                'prenom' => 'Amine',
                'role' => 'Développeur Fullstack',
                'image' => 'https://i.pravatar.cc/150?img=11',
                'skills' => ['Laravel', 'Vue.js', 'Docker']
            ],
            [
                'id' => 2,
                'nom' => 'Tazi',
                'prenom' => 'Sara',
                'role' => 'UX/UI Designer',
                'image' => 'https://i.pravatar.cc/150?img=5',
                'skills' => ['Figma', 'Adobe XD', 'Prototyping']
            ],
            [
                'id' => 3,
                'nom' => 'Idrissi',
                'prenom' => 'Karim',
                'role' => 'DevOps Engineer',
                'image' => 'https://i.pravatar.cc/150?img=33',
                'skills' => ['AWS', 'Kubernetes', 'CI/CD']
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
                <!-- Quick Actions -->
                <div class="rounded-3xl bg-white p-8 shadow-sm ring-1 ring-slate-900/5">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-lg font-bold text-slate-900 flex items-center gap-2">
                            <span class="h-2 w-2 rounded-full bg-indigo-500"></span>
                            Actions Rapides
                        </h3>
                    </div>
                    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                        <a href="{{ url('/search') }}" class="group relative flex items-center gap-x-6 rounded-2xl bg-slate-50 p-4 hover:bg-slate-100 transition-colors">
                            <div class="flex h-12 w-12 flex-none items-center justify-center rounded-xl bg-white shadow-sm ring-1 ring-slate-900/5 group-hover:ring-indigo-500 transition-all">
                                <svg class="h-6 w-6 text-slate-600 group-hover:text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-base font-semibold leading-7 tracking-tight text-slate-900">Rechercher des talents</h3>
                                <p class="text-sm leading-6 text-slate-600">Filtrer par compétences, rôle...</p>
                            </div>
                        </a>
                        <a href="{{ url('/offers/create') }}" class="group relative flex items-center gap-x-6 rounded-2xl bg-slate-50 p-4 hover:bg-slate-100 transition-colors">
                            <div class="flex h-12 w-12 flex-none items-center justify-center rounded-xl bg-white shadow-sm ring-1 ring-slate-900/5 group-hover:ring-indigo-500 transition-all">
                                <svg class="h-6 w-6 text-slate-600 group-hover:text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4v16m8-8H4" />
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-base font-semibold leading-7 tracking-tight text-slate-900">Nouvelle Offre</h3>
                                <p class="text-sm leading-6 text-slate-600">Publier un poste gratuitement.</p>
                            </div>
                        </a>
                         <a href="{{ url('/relationships') }}" class="group relative flex items-center gap-x-6 rounded-2xl bg-slate-50 p-4 hover:bg-slate-100 transition-colors">
                            <div class="flex h-12 w-12 flex-none items-center justify-center rounded-xl bg-white shadow-sm ring-1 ring-slate-900/5 group-hover:ring-indigo-500 transition-all">
                                <svg class="h-6 w-6 text-slate-600 group-hover:text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-base font-semibold leading-7 tracking-tight text-slate-900">Mon Réseau</h3>
                                <p class="text-sm leading-6 text-slate-600">Gérer mes connexions.</p>
                            </div>
                        </a>
                        <a href="{{ url('/profile/manage') }}" class="group relative flex items-center gap-x-6 rounded-2xl bg-slate-50 p-4 hover:bg-slate-100 transition-colors">
                            <div class="flex h-12 w-12 flex-none items-center justify-center rounded-xl bg-white shadow-sm ring-1 ring-slate-900/5 group-hover:ring-indigo-500 transition-all">
                                <svg class="h-6 w-6 text-slate-600 group-hover:text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-base font-semibold leading-7 tracking-tight text-slate-900">Paramètres</h3>
                                <p class="text-sm leading-6 text-slate-600">Modifier mon profil.</p>
                            </div>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Right Sidebar (1/3) -->
            <div class="space-y-8">
                 <!-- Suggestions -->
                 <div class="rounded-3xl bg-white p-6 shadow-sm ring-1 ring-slate-900/5">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-lg font-bold text-slate-900">Talents suggérés</h3>
                        <a href="{{ url('/search') }}" class="text-sm font-semibold text-indigo-600 hover:text-indigo-500">Tout voir</a>
                    </div>
                    <ul role="list" class="-my-5 divide-y divide-slate-100">
                        @foreach($suggestions as $suggestor)
                            <li class="py-4">
                                <div class="flex items-center gap-x-3">
                                    <img src="{{ $suggestor['image'] }}" alt="" class="h-10 w-10 flex-none rounded-full bg-slate-50 object-cover">
                                    <div class="flex-auto">
                                        <p class="text-sm font-semibold leading-6 text-slate-900">{{ $suggestor['prenom'] }} {{ $suggestor['nom'] }}</p>
                                        <p class="text-xs leading-5 text-slate-500">{{ $suggestor['role'] }}</p>
                                    </div>
                                    <button class="rounded-full bg-slate-50 p-2 text-slate-400 hover:text-indigo-600 hover:bg-slate-100 transition-all">
                                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                        </svg>
                                    </button>
                                </div>
                                <div class="mt-2 flex gap-1 flex-wrap">
                                    @foreach($suggestor['skills'] as $skill)
                                        <span class="inline-flex items-center rounded-md bg-slate-50 px-2 py-1 text-xs font-medium text-slate-600 ring-1 ring-inset ring-slate-500/10">{{ $skill }}</span>
                                    @endforeach
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>

                <!-- Premium Promo -->
                @if(!$u->subscribed('default'))
                    <div class="relative overflow-hidden rounded-3xl bg-slate-900 px-6 py-6 shadow-xl">
                        <div class="absolute inset-0 bg-gradient-to-br from-indigo-500 to-purple-600 opacity-90"></div>
                        <div class="relative">
                            <h3 class="text-lg font-bold text-white tracking-tight">Passez au Premium 🚀</h3>
                            <p class="mt-2 text-sm text-indigo-100">Contactez illimité, visibilité accrue et badge PRO sur votre profil.</p>
                            <a href="{{ route('premium') }}" class="mt-4 block w-full rounded-xl bg-white px-3 py-2 text-center text-sm font-semibold text-indigo-600 shadow-sm hover:bg-indigo-50 transition-all">
                                Découvrir les offres
                            </a>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
