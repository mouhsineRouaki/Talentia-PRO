<x-app-layout>
    <x-slot name="header">
        <div class="relative overflow-hidden rounded-3xl bg-indigo-900 px-6 py-10 shadow-xl sm:px-12 sm:py-16">
            <div class="absolute inset-0">
                <img src="https://images.unsplash.com/photo-1542744173-8e7e53415bb0?ixlib=rb-4.0.3&auto=format&fit=crop&w=2830&q=80&blend=1e1b4b&sat=-100&blend-mode=multiply" alt="" class="h-full w-full object-cover">
            </div>
            <div class="absolute inset-0 bg-gradient-to-r from-indigo-900 via-indigo-900/90 to-transparent"></div>
            <div class="relative max-w-3xl">
                <div class="flex items-center gap-3">
                    <span class="inline-flex items-center rounded-full bg-indigo-500/10 px-3 py-1 text-xs font-medium text-indigo-200 ring-1 ring-inset ring-indigo-500/20">
                        Espace Recrutement
                    </span>
                </div>
                <h2 class="mt-4 text-3xl font-bold tracking-tight text-white sm:text-4xl">
                    Gérez vos offres d'emploi 💼
                </h2>
                <p class="mt-4 text-lg text-indigo-200">
                    Créez, modifiez et suivez vos offres en temps réel. Trouvez les talents qu'il vous faut.
                </p>
                <div class="mt-8">
                     <div x-data="{ open:false }">
                        <button @click="open = true"
                                class="rounded-full bg-white px-5 py-3 text-sm font-semibold text-indigo-900 shadow-sm hover:bg-indigo-50 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-white transition-all duration-300 flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                            </svg>
                            Créer une nouvelle offre
                        </button>

                         <template x-teleport="body">
                            <div
                                x-cloak
                                x-show="open"
                                x-transition.opacity
                                @keydown.escape.window="open = false"
                                class="fixed inset-0 z-[9999] flex items-center justify-center p-4"
                            >
                                <!-- overlay -->
                                <div class="absolute inset-0 bg-slate-900/60 backdrop-blur-sm" @click="open=false"></div>

                                <!-- panel -->
                                <div
                                    @click.stop
                                    x-transition
                                    class="relative z-10 w-full max-w-2xl rounded-[2rem] bg-white shadow-2xl border border-slate-200 overflow-hidden"
                                >
                                    <div class="p-6 border-b border-slate-200 flex items-center justify-between bg-slate-50">
                                        <div>
                                            <h3 class="text-xl font-bold text-slate-900">Nouvelle offre</h3>
                                            <p class="text-sm text-slate-500">Remplissez les détails du poste.</p>
                                        </div>
                                        <button @click="open=false" class="p-2 rounded-xl hover:bg-slate-200 text-slate-500 transition-colors">
                                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                            </svg>
                                        </button>
                                    </div>

                                    <form method="POST" action="{{ route('offers.store') }}" class="p-8 space-y-6">
                                        @csrf

                                        @if ($errors->any())
                                            <div class="rounded-2xl border border-rose-200 bg-rose-50 p-4 text-sm text-rose-700">
                                                <ul class="list-disc ms-5">
                                                    @foreach ($errors->all() as $e)
                                                        <li>{{ $e }}</li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        @endif

                                        <div class="grid gap-6 sm:grid-cols-2">
                                            <div class="space-y-2">
                                                <label class="text-sm font-bold text-slate-700">Titre du poste *</label>
                                                <input name="titre" type="text" placeholder="Ex: Développeur Senior" required
                                                       class="w-full rounded-xl border-slate-200 bg-slate-50 px-4 py-3 text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-shadow"/>
                                            </div>

                                            <div class="space-y-2">
                                                <label class="text-sm font-bold text-slate-700">Type de contrat *</label>
                                                <select name="type_contrat" required
                                                        class="w-full rounded-xl border-slate-200 bg-slate-50 px-4 py-3 text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-shadow">
                                                    <option value="CDI">CDI</option>
                                                    <option value="CDD">CDD</option>
                                                    <option value="Freelance">Freelance</option>
                                                    <option value="Stage">Stage</option>
                                                    <option value="Alternance">Alternance</option>
                                                </select>
                                            </div>

                                            <div class="space-y-2">
                                                <label class="text-sm font-bold text-slate-700">Ville / Localisation</label>
                                                <input name="ville" type="text" placeholder="Ex: Paris, Télétravail..."
                                                       class="w-full rounded-xl border-slate-200 bg-slate-50 px-4 py-3 text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-shadow"/>
                                            </div>

                                             <div class="space-y-2">
                                                <label class="text-sm font-bold text-slate-700">Image de couverture (URL) *</label>
                                                <input name="image" type="url" placeholder="https://..." required
                                                       class="w-full rounded-xl border-slate-200 bg-slate-50 px-4 py-3 text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-shadow"/>
                                            </div>

                                            <div class="sm:col-span-2 space-y-2">
                                                <label class="text-sm font-bold text-slate-700">Description du poste *</label>
                                                <textarea name="description" rows="5" placeholder="Missions, profil recherché, avantages..." required
                                                          class="w-full rounded-xl border-slate-200 bg-slate-50 px-4 py-3 text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-shadow"></textarea>
                                            </div>
                                        </div>

                                        <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-100">
                                            <button type="button" @click="open=false"
                                                    class="rounded-xl border border-slate-200 px-6 py-3 text-sm font-bold text-slate-700 hover:bg-slate-50 transition-colors">
                                                Annuler
                                            </button>
                                            <button type="submit"
                                                    class="rounded-xl bg-indigo-600 px-6 py-3 text-sm font-bold text-white shadow-lg shadow-indigo-500/30 hover:bg-indigo-700 hover:shadow-indigo-500/40 transition-all">
                                                Publier l'offre
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </template>
                     </div>
                </div>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">

            @if(session('success'))
                <div class="rounded-2xl border border-emerald-200 bg-emerald-50 p-4 flex items-center gap-3 text-sm font-semibold text-emerald-800 shadow-sm">
                    <svg class="h-5 w-5 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    {{ session('success') }}
                </div>
            @endif

            <!-- Cards -->
            <div class="grid gap-8 sm:grid-cols-2 lg:grid-cols-3">
                @forelse($offers as $offer)
                    <x-job-offer-card :offer="$offer" />
                @empty
                    <div class="sm:col-span-2 lg:col-span-3 rounded-3xl bg-white p-12 text-center ring-1 ring-slate-200 shadow-sm">
                        <div class="mx-auto h-24 w-24 rounded-full bg-indigo-50 flex items-center justify-center mb-6">
                            <svg class="h-12 w-12 text-indigo-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-slate-900">Aucune offre publiée</h3>
                        <p class="mt-2 text-slate-500 max-w-md mx-auto">Vous n'avez pas encore publié d'offres. Commencez dès maintenant pour trouver vos futurs collaborateurs.</p>
                    </div>
                @endforelse
            </div>

        </div>
    </div>
</x-app-layout>
