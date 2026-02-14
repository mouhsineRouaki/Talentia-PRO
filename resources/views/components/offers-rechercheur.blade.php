@props([
    'offer',
    'applied' => false,
])

@php
    $score = $this->getMcp($offer->id);
    $pct = $score['percentage'];
    $possible = $score['possiblePostule'];
    
    $recruteurUser = $offer->recruteur?->user;
    $recruteurName = trim(($recruteurUser->prenom ?? '').' '.($recruteurUser->nom ?? ($recruteurUser->name ?? 'Recruteur')));
    $recruteurImg = $recruteurUser->image ?? 'https://i.pravatar.cc/150?img=3';

    $isClosed = (bool) $offer->is_closed;
    $canApply = !$applied && !$isClosed && $possible; // Removed pct > 0 strict check for now, let them try but warn

    $desc = \Illuminate\Support\Str::limit($offer->description ?? '', 160);
@endphp

<article class="group relative w-full rounded-2xl bg-white border border-slate-200 transition-all duration-300 hover:shadow-lg hover:shadow-indigo-500/5 hover:border-indigo-100 overflow-hidden">
    
    <div class="p-6">
        <div class="flex items-start gap-4">
            <!-- Avatar -->
            <div class="relative shrink-0">
                <img src="{{ $recruteurImg }}" class="h-14 w-14 rounded-2xl object-cover bg-slate-100 shadow-sm ring-1 ring-slate-100" alt="">
                @if($pct >= 80)
                    <div class="absolute -bottom-2 -right-2 rounded-full bg-emerald-100 px-1.5 py-0.5 text-[10px] font-bold text-emerald-700 shadow-sm ring-2 ring-white">
                        {{ $pct }}% Match
                    </div>
                @endif
            </div>

            <!-- Content -->
            <div class="min-w-0 flex-1">
                <div class="flex items-start justify-between gap-4">
                    <div>
                        <h3 class="text-lg font-bold text-slate-900 leading-tight group-hover:text-indigo-600 transition-colors">
                            {{ $offer->titre }}
                        </h3>
                        <p class="text-sm font-medium text-slate-500 mt-1">
                            {{ $recruteurName }} 
                            <span class="text-slate-300 mx-1">&bull;</span> 
                            {{ optional($offer->created_at)->diffForHumans() }}
                        </p>
                    </div>

                    <div class="flex flex-col items-end gap-2 shrink-0">
                        @if($isClosed)
                             <span class="inline-flex items-center rounded-full bg-rose-50 px-2.5 py-1 text-xs font-bold text-rose-700 ring-1 ring-inset ring-rose-600/20">
                                Clôturée
                            </span>
                        @else
                            <span class="inline-flex items-center rounded-full bg-emerald-50 px-2.5 py-1 text-xs font-bold text-emerald-700 ring-1 ring-inset ring-emerald-600/20">
                                Active
                            </span>
                        @endif
                    </div>
                </div>

                <!-- Meta Badges -->
                <div class="mt-3 flex flex-wrap gap-2">
                    <span class="inline-flex items-center rounded-lg bg-slate-50 px-2.5 py-1 text-xs font-medium text-slate-600 ring-1 ring-inset ring-slate-500/10">
                        <svg class="mr-1.5 h-3.5 w-3.5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                        {{ $offer->type_contrat }}
                    </span>
                    @if($offer->ville)
                        <span class="inline-flex items-center rounded-lg bg-slate-50 px-2.5 py-1 text-xs font-medium text-slate-600 ring-1 ring-inset ring-slate-500/10">
                             <svg class="mr-1.5 h-3.5 w-3.5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            {{ $offer->ville }}
                        </span>
                    @endif
                </div>
                
                <p class="mt-4 text-sm text-slate-600 leading-relaxed line-clamp-2">
                    {{ $desc }}
                </p>
            </div>
        </div>

        @if($offer->image)
            <div class="mt-4 hidden sm:block">
                 <div class="h-40 w-full rounded-xl overflow-hidden relative group-hover:shadow-inner transition-all">
                     <img src="{{ $offer->image }}" alt="" class="h-full w-full object-cover transition-transform duration-700 group-hover:scale-105">
                     <div class="absolute inset-0 bg-gradient-to-t from-slate-900/10 to-transparent"></div>
                 </div>
            </div>
        @endif
    </div>

    <!-- Actions -->
    <div class="px-6 py-4 bg-slate-50/50 border-t border-slate-100 flex items-center justify-between gap-4">
        
        <div class="flex items-center gap-2">
             @if($pct > 0)
                <div class="text-xs font-medium text-slate-500">
                    Match IA: <span class="font-bold {{ $pct >= 70 ? 'text-emerald-600' : ($pct >= 50 ? 'text-amber-600' : 'text-slate-600') }}">{{ $pct }}%</span>
                </div>
             @endif
        </div>

        <button
            type="button"
            wire:click="openApply({{ $offer->id }})"
            @disabled(!$canApply)
            class="inline-flex items-center justify-center gap-2 rounded-xl px-5 py-2.5 text-sm font-bold transition-all shadow-sm
                {{ (!$possible)
                    ? 'bg-slate-100 text-slate-400 cursor-not-allowed border border-slate-200'
                    : ($applied
                        ? 'bg-emerald-50 text-emerald-700 border border-emerald-200 cursor-default'
                        : ($isClosed
                            ? 'bg-slate-100 text-slate-400 cursor-not-allowed border border-slate-200'
                            : 'bg-slate-900 text-white hover:bg-indigo-600 hover:shadow-indigo-500/20 active:scale-95'))
                }}"
        >
            @if($applied)
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
                Postulé
            @elseif($isClosed)
                Clôturée
            @elseif(!$possible)
                Profil incomplet
            @else
                Postuler
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                     <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                </svg>
            @endif
        </button>
    </div>
</article>
