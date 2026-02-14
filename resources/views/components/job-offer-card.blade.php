@props(['offer'])

@php
    $title = $offer->titre;
    $desc  = \Illuminate\Support\Str::limit($offer->description, 100);
    $ville = $offer->ville ?: 'Non spécifié';
    $type  = $offer->type_contrat;
    $img   = $offer->image;
    $isClosed = (bool) $offer->is_closed;

    $company = optional($offer->recruteur)->entreprise ?? 'Mon Entreprise';
    $created = optional($offer->created_at)->diffForHumans() ?? '';
@endphp

<article class="group relative flex flex-col overflow-hidden rounded-3xl bg-white border border-slate-200 transition-all duration-300 hover:shadow-xl hover:shadow-indigo-500/10 hover:-translate-y-1">

    <!-- Image & Badge -->
    <div class="relative h-48 w-full overflow-hidden bg-slate-100">
        <img src="{{ $img }}" alt="{{ $title }}" class="h-full w-full object-cover transition-transform duration-700 group-hover:scale-105">
        <div class="absolute inset-0 bg-gradient-to-t from-slate-900/80 via-transparent to-transparent"></div>
        
        <div class="absolute top-4 left-4 right-4 flex justify-between items-start">
            <span class="inline-flex items-center rounded-lg bg-white/90 backdrop-blur px-2.5 py-1 text-xs font-bold text-slate-800 shadow-sm">
                {{ $type }}
            </span>

            @if($isClosed)
                <span class="inline-flex items-center rounded-lg bg-rose-500/90 backdrop-blur px-2.5 py-1 text-xs font-bold text-white shadow-sm">
                    Clôturée
                </span>
            @else
                <span class="inline-flex items-center rounded-lg bg-emerald-500/90 backdrop-blur px-2.5 py-1 text-xs font-bold text-white shadow-sm flex gap-1">
                    <span class="relative flex h-2 w-2">
                      <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                      <span class="relative inline-flex rounded-full h-2 w-2 bg-emerald-500"></span>
                    </span>
                    Active
                </span>
            @endif
        </div>

        <div class="absolute bottom-4 left-4 text-white">
             <div class="flex items-center gap-2 text-xs font-medium text-slate-300 mb-1">
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
                {{ $ville }}
            </div>
            <h3 class="text-xl font-bold leading-tight line-clamp-2">
                {{ $title }}
            </h3>
        </div>
    </div>

    <!-- Content -->
    <div class="flex-1 p-5 flex flex-col">
        <p class="text-sm text-slate-500 leading-relaxed mb-4 line-clamp-3">
            {{ $desc }}
        </p>

        <div class="mt-auto pt-4 border-t border-slate-100 flex items-center justify-between gap-3">
            <div class="text-xs text-slate-400 font-medium">
                Publiée {{ $created }}
            </div>
            
             <a href="{{ route('offers.recruteur.show', $offer) }}" class="text-sm font-bold text-indigo-600 hover:text-indigo-700 hover:underline">
                Voir détails &rarr;
            </a>
        </div>
        
         <div class="mt-4 flex items-center gap-2">
            @if(!$isClosed)
                <form method="POST" action="{{ route('offers.close', $offer->id) }}" class="w-full">
                    @csrf
                    <button type="submit"
                            class="w-full rounded-xl bg-slate-50 border border-slate-200 px-4 py-2.5 text-sm font-bold text-slate-600 hover:bg-rose-50 hover:text-rose-600 hover:border-rose-200 transition-all flex items-center justify-center gap-2 group/btn">
                        <svg class="h-4 w-4 text-slate-400 group-hover/btn:text-rose-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636" />
                        </svg>
                        Clôturer l'offre
                    </button>
                </form>
            @else
                <button disabled
                        class="w-full rounded-xl bg-slate-100 px-4 py-2.5 text-sm font-bold text-slate-400 cursor-not-allowed flex items-center justify-center gap-2">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                    </svg>
                    Offre fermée
                </button>
            @endif
        </div>
    </div>
</article>
