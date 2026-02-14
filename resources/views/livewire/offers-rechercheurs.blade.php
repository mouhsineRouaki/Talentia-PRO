<div class="space-y-8">

    @if(session('success'))
        <div class="rounded-2xl border border-emerald-200 bg-emerald-50 p-4 flex items-center gap-3 text-sm font-semibold text-emerald-800 shadow-sm animate-in fade-in slide-in-from-top-2">
            <svg class="h-5 w-5 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            {{ session('success') }}
        </div>
    @endif

    <!-- Filters Section -->
    <div class="rounded-3xl bg-white border border-slate-200 shadow-sm p-6 lg:p-8">
        <div class="flex items-center gap-2 mb-6">
            <div class="p-2 rounded-lg bg-indigo-50 text-indigo-600">
                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                </svg>
            </div>
            <h3 class="text-lg font-bold text-slate-900">Filtrer les offres</h3>
        </div>

        <div class="grid gap-5 md:grid-cols-4">
            <div class="md:col-span-2 space-y-1.5">
                <label class="text-xs font-bold uppercase tracking-wider text-slate-500 ml-1">Mots-clés</label>
                <div class="relative">
                    <input type="text" wire:model.live.debounce.300ms="q"
                           placeholder="Développeur, Designer, Marketing..."
                           class="w-full rounded-xl border-slate-200 bg-slate-50 pl-10 pr-4 py-3 text-sm font-medium focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-shadow" />
                    <svg class="absolute left-3.5 top-3.5 h-5 w-5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </div>
            </div>

            <div class="space-y-1.5">
                <label class="text-xs font-bold uppercase tracking-wider text-slate-500 ml-1">Contrat</label>
                <div class="relative">
                    <select wire:model.live="type"
                            class="w-full appearance-none rounded-xl border-slate-200 bg-slate-50 pl-4 pr-10 py-3 text-sm font-medium focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-shadow">
                        <option value="">Tous les types</option>
                        <option value="CDI">CDI</option>
                        <option value="CDD">CDD</option>
                        <option value="Freelance">Freelance</option>
                        <option value="Stage">Stage</option>
                        <option value="Alternance">Alternance</option>
                    </select>
                     <svg class="absolute right-3.5 top-3.5 h-5 w-5 text-slate-400 pointer-events-none" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </div>
            </div>

            <div class="space-y-1.5">
                <label class="text-xs font-bold uppercase tracking-wider text-slate-500 ml-1">Ville</label>
                <div class="relative">
                    <input type="text" wire:model.live.debounce.300ms="ville"
                           placeholder="Casablanca, Rabat..."
                           class="w-full rounded-xl border-slate-200 bg-slate-50 pl-10 pr-4 py-3 text-sm font-medium focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-shadow" />
                    <svg class="absolute left-3.5 top-3.5 h-5 w-5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                </div>
            </div>

            <div class="md:col-span-4 flex items-center justify-between pt-2 border-t border-slate-100 mt-2">
                <label class="inline-flex items-center gap-2.5 cursor-pointer group">
                    <div class="relative flex items-center">
                        <input type="checkbox" wire:model.live="openOnly" class="peer sr-only">
                        <div class="h-6 w-11 rounded-full bg-slate-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-indigo-300 transition-colors peer-checked:bg-indigo-600"></div>
                        <div class="absolute left-1 top-1 h-4 w-4 rounded-full bg-white transition-transform peer-checked:translate-x-full"></div>
                    </div>
                    <span class="text-sm font-semibold text-slate-600 group-hover:text-slate-900 transition-colors">Masquer les offres clôturées</span>
                </label>

                <button type="button"
                        wire:click="$set('q',''); $set('type',''); $set('ville',''); $set('openOnly', true)"
                        class="text-sm font-bold text-slate-400 hover:text-indigo-600 transition-colors flex items-center gap-1">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                    </svg>
                    Réinitialiser
                </button>
            </div>
        </div>
    </div>

    <!-- Feed -->
    <div class="max-w-4xl mx-auto space-y-6">
        @forelse($offers as $offer)
            <x-offers-rechercheur
                :offer="$offer"
                :applied="in_array($offer->id, $appliedOfferIds, true)"
            />
        @empty
            <div class="rounded-3xl bg-white border border-slate-200 p-12 text-center shadow-sm">
                <div class="mx-auto h-20 w-20 rounded-full bg-slate-50 flex items-center justify-center mb-6">
                    <svg class="h-10 w-10 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </div>
                <h3 class="text-lg font-bold text-slate-900">Aucune offre trouvée</h3>
                <p class="mt-2 text-slate-500">Essayez de modifier vos filtres ou revenez plus tard.</p>
            </div>
        @endforelse

        @if(count($offers) >= $perPage)
            <div class="pt-4 text-center">
                <button wire:click="loadMore" wire:loading.attr="disabled"
                        class="inline-flex items-center gap-2 rounded-full bg-white px-6 py-3 text-sm font-bold text-slate-700 shadow-sm ring-1 ring-slate-200 hover:bg-slate-50 hover:text-indigo-600 transition-all">
                    <svg wire:loading.remove class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 13l-7 7-7-7m14-8l-7 7-7-7" />
                    </svg>
                    <svg wire:loading class="animate-spin h-4 w-4 text-indigo-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    Charger plus d'offres
                </button>
            </div>
        @endif
    </div>

    <!-- Apply Modal -->
    @if($showApplyModal && $selectedOffer)
        <div class="fixed inset-0 z-[100] flex items-center justify-center p-4" wire:click.self="closeApply">
            <div class="absolute inset-0 bg-slate-900/60 backdrop-blur-sm transition-opacity"></div>

            <div class="relative w-full max-w-2xl transform rounded-[2rem] bg-white border border-slate-200 shadow-2xl transition-all overflow-hidden">
                <div class="p-6 border-b border-slate-100 flex items-start justify-between bg-slate-50/50">
                    <div>
                        <h3 class="text-xl font-bold text-slate-900">Postuler à l'offre</h3>
                         <div class="mt-1 flex items-center gap-2 text-sm text-slate-500">
                            <span class="font-semibold text-indigo-600">{{ $selectedOffer->titre }}</span>
                            <span>&bull;</span>
                            <span class="inline-flex items-center rounded-md bg-slate-100 px-2 py-0.5 text-xs font-medium text-slate-600">
                                {{ $selectedOffer->type_contrat }}
                            </span>
                        </div>
                    </div>

                    <button type="button" wire:click="closeApply" class="p-2 rounded-xl hover:bg-slate-200 text-slate-400 hover:text-slate-600 transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>

                <form wire:submit.prevent="apply" class="p-8 space-y-6">
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Message au recruteur <span class="text-slate-400 font-normal">(Optionnel)</span></label>
                        <textarea wire:model.defer="message" rows="6"
                                  placeholder="Présentez-vous brièvement, expliquez vos motivations..."
                                  class="w-full rounded-2xl border-slate-200 bg-slate-50 px-5 py-4 text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-shadow placeholder:text-slate-400"></textarea>
                        @error('message') <p class="mt-2 text-xs font-bold text-rose-500 flex items-center gap-1"><svg class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>{{ $message }}</p> @enderror
                        <p class="mt-3 text-xs text-slate-400">
                            Votre profil complet sera automatiquement envoyé avec cette candidature.
                        </p>
                    </div>

                    <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-100">
                        <button type="button" wire:click="closeApply"
                                class="rounded-xl border border-slate-200 px-6 py-3 text-sm font-bold text-slate-700 hover:bg-slate-50 transition-colors">
                            Annuler
                        </button>

                        <button type="submit" wire:loading.attr="disabled"
                                class="rounded-xl bg-indigo-600 px-6 py-3 text-sm font-bold text-white shadow-lg shadow-indigo-500/30 hover:bg-indigo-700 hover:shadow-indigo-500/40 transition-all flex items-center gap-2">
                             <span wire:loading.remove>Confirm & Postuler</span>
                             <span wire:loading class="flex items-center gap-2">
                                <svg class="animate-spin h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                                Envoi...
                             </span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif

</div>
