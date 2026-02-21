<x-app-layout>
    <div class="min-h-screen bg-slate-50 font-sans relative overflow-hidden">
        <!-- Background Atmosphere -->
        <div class="fixed inset-0 pointer-events-none z-0">
            <div class="absolute top-0 left-1/4 w-[600px] h-[600px] bg-indigo-100/40 rounded-full blur-3xl mix-blend-multiply opacity-70"></div>
            <div class="absolute bottom-0 right-1/4 w-[500px] h-[500px] bg-purple-100/40 rounded-full blur-3xl mix-blend-multiply opacity-70"></div>
        </div>

        <div class="relative z-10 py-12 max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- Header -->
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-10">
                <div>
                    <h1 class="text-3xl font-black text-slate-900 tracking-tight flex items-center gap-3">
                        Notifications
                        <span class="inline-flex items-center justify-center bg-indigo-600 text-white text-xs font-bold w-6 h-6 rounded-full shadow-lg shadow-indigo-500/30">
                            {{ $notifications->count() }}
                        </span>
                    </h1>
                    <p class="text-slate-500 font-medium mt-1">Restez informé de vos dernières activités.</p>
                </div>

                @if($notifications->count() > 0)
                <form action="{{ route('notifications.mark-all-read') }}" method="POST">
                    @csrf
                    <button type="submit" class="inline-flex items-center gap-2 px-4 py-2.5 bg-white text-slate-600 text-sm font-bold rounded-xl border border-slate-200 hover:bg-slate-50 hover:text-indigo-600 transition-all shadow-sm">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                        Tout marquer comme lu
                    </button>
                </form>
                @endif
            </div>

            @php
                $getNotificationConfig = function ($content) {
                    if (str_contains($content, 'Offre') || str_contains(strtolower($content), 'nouvelle offre')) {
                        return [
                            'type' => 'offer',
                            'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />',
                            'color' => 'indigo',
                            'bg' => 'bg-indigo-50',
                            'text' => 'text-indigo-600',
                            'ring' => 'ring-indigo-100',
                            'label' => 'Offre d\'emploi',
                            'action_url' => route('offers.rechercheurs.index'),
                            'action_text' => 'Voir l\'offre'
                        ];
                    } elseif (str_contains(strtolower($content), 'ami') || str_contains(strtolower($content), 'invitation')) {
                        return [
                            'type' => 'friend',
                            'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />',
                            'color' => 'purple',
                            'bg' => 'bg-purple-50',
                            'text' => 'text-purple-600',
                            'ring' => 'ring-purple-100',
                            'label' => 'Connexion',
                            'action_url' => route('friends.index'),
                            'action_text' => 'Gérer'
                        ];
                    } elseif (str_contains(strtolower($content), 'accepté')) {
                        return [
                            'type' => 'success',
                            'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />',
                            'color' => 'emerald',
                            'bg' => 'bg-emerald-50',
                            'text' => 'text-emerald-600',
                            'ring' => 'ring-emerald-100',
                            'label' => 'Succès',
                            'action_url' => null,
                            'action_text' => null
                        ];
                    } else {
                        return [
                            'type' => 'info',
                            'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />',
                            'color' => 'slate',
                            'bg' => 'bg-slate-50',
                            'text' => 'text-slate-500',
                            'ring' => 'ring-slate-100',
                            'label' => 'Information',
                            'action_url' => null,
                            'action_text' => null
                        ];
                    }
                };
            @endphp

            <div class="space-y-4">
                @forelse($notifications as $n)
                    @php $config = $getNotificationConfig($n->contenu); @endphp
                    
                    <div class="group relative bg-white/80 backdrop-blur-sm rounded-2xl p-5 border border-white shadow-sm hover:shadow-md hover:bg-white transition-all duration-300 animate-in fade-in slide-in-from-bottom-2">
                        <div class="flex items-start gap-4">
                            <!-- Icon -->
                            <div class="shrink-0">
                                <span class="flex items-center justify-center w-12 h-12 rounded-xl {{ $config['bg'] }} {{ $config['text'] }} ring-1 {{ $config['ring'] }}">
                                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        {!! $config['icon'] !!}
                                    </svg>
                                </span>
                            </div>

                            <!-- Content -->
                            <div class="flex-1 min-w-0 pt-1">
                                <div class="flex flex-wrap items-center justify-between gap-2 mb-1">
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-bold uppercase tracking-wide {{ $config['bg'] }} {{ $config['text'] }}">
                                        {{ $config['label'] }}
                                    </span>
                                    <span class="text-xs font-bold text-slate-400 group-hover:text-indigo-400 transition-colors">
                                        {{ $n->created_at->diffForHumans() }}
                                    </span>
                                </div>
                                <p class="text-slate-700 leading-relaxed font-medium">
                                    {{ $n->contenu }}
                                </p>
                                
                                @if($config['action_url'])
                                <div class="mt-3">
                                    <a href="{{ $config['action_url'] }}" class="inline-flex items-center gap-1 text-sm font-bold {{ $config['text'] }} hover:underline decoration-2 underline-offset-2 transition-all">
                                        {{ $config['action_text'] }}
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" /></svg>
                                    </a>
                                </div>
                                @endif
                            </div>
                            
                            <!-- delete -->
                            <form action="{{ route('notifications.delete', $n->id) }}" method="POST" onsubmit="return confirm('supprimer cette notification ?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-slate-300 hover:text-rose-500 transition-colors p-1" title="Supprimer">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                                </button>
                            </form>
                        </div>
                    </div>
                @empty
                    <div class="flex flex-col items-center justify-center py-20 text-center">
                        <div class="w-24 h-24 bg-white rounded-3xl shadow-[0_20px_40px_rgba(0,0,0,0.05)] border border-slate-100 flex items-center justify-center mb-6 transform rotate-3">
                            <div class="w-20 h-20 bg-slate-50 rounded-2xl flex items-center justify-center">
                                <svg class="w-10 h-10 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" /></svg>
                            </div>
                        </div>
                        <h3 class="text-xl font-black text-slate-900 mb-2">Tout est calme</h3>
                        <p class="text-slate-500 max-w-sm mx-auto leading-relaxed">
                            Vous n'avez aucune notification pour le moment. Revenez plus tard !
                        </p>
                    </div>
                @endforelse
            </div>

        </div>
    </div>
</x-app-layout>