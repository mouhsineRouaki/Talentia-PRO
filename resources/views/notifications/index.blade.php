<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-semibold text-xl text-slate-900 leading-tight">Notifications</h2>
                <p class="text-sm text-slate-500">Historique des notifications (statique).</p>
            </div>
            <button
                class="rounded-xl border border-slate-200 px-4 py-2.5 text-sm font-semibold text-slate-700 hover:bg-slate-50">
                Tout marquer comme lu
            </button>
        </div>
    </x-slot>

    @php
        $badgeClass = fn($type) => match ($type) {
            'offer' => 'bg-indigo-50 text-indigo-700 ring-indigo-200',
            'friend_request' => 'bg-blue-50 text-blue-700 ring-blue-200',
            'accepted' => 'bg-emerald-50 text-emerald-700 ring-emerald-200',
            default => 'bg-slate-100 text-slate-700 ring-slate-200',
        };

        $badgeLabel = fn($type) => match ($type) {
            'offer' => 'Offre',
            'friend_request' => 'Amitié',
            'accepted' => 'Acceptée',
            default => 'Info',
        };

        $getNotificationType = function ($content) {
            if (str_contains($content, 'Offre'))
                return 'offer';
            if (str_contains($content, 'amitié'))
                return 'friend_request';
            if (str_contains($content, 'accepté'))
                return 'accepted';
            return 'info';
        };
    @endphp

    <div class="py-10">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 space-y-4">

            @forelse($notifications as $n)
                @php
                    $type = $getNotificationType($n->contenu);
                @endphp
                <div class="rounded-2xl bg-white p-5 shadow-sm ring-1 ring-slate-200 hover:shadow-md transition">
                    <div class="flex items-start justify-between gap-4">
                        <div class="flex items-start gap-3">
                            <div
                                class="h-11 w-11 rounded-2xl bg-slate-200 shrink-0 flex items-center justify-center text-slate-500">
                                @if($type === 'offer')
                                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                    </svg>
                                @elseif($type === 'friend_request')
                                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                                    </svg>
                                @else
                                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                @endif
                            </div>

                            <div class="min-w-0">
                                <div class="flex flex-wrap items-center gap-2">
                                    <h3 class="font-semibold text-slate-900">
                                        @if($type === 'offer') Nouvel Offre @elseif($type === 'friend_request') Demande
                                        d'ami @else Notification @endif
                                    </h3>
                                    <span
                                        class="inline-flex items-center rounded-full px-2.5 py-1 text-xs font-semibold ring-1 {{ $badgeClass($type) }}">
                                        {{ $badgeLabel($type) }}
                                    </span>
                                    <span class="text-xs text-slate-500">{{ $n->created_at->diffForHumans() }}</span>
                                </div>

                                <p class="mt-1 text-sm text-slate-600">
                                    {{ $n->contenu }}
                                </p>
                            </div>
                        </div>

                        <div class="flex shrink-0 gap-2">
                            @if($type === 'offer')
                                <a href="{{ route('offers.rechercheurs.index') }}"
                                    class="rounded-xl bg-blue-600 px-3 py-2 text-sm font-semibold text-white hover:bg-blue-700">
                                    Voir Offres
                                </a>
                            @elseif($type === 'friend_request')
                                <a href="{{ route('friends.index') }}"
                                    class="rounded-xl bg-blue-600 px-3 py-2 text-sm font-semibold text-white hover:bg-blue-700">
                                    Voir Demandes
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            @empty
                <div class="rounded-2xl bg-white p-6 shadow-sm ring-1 ring-slate-200 text-sm text-slate-500">
                    Aucune notification.
                </div>
            @endforelse

        </div>
    </div>
</x-app-layout>