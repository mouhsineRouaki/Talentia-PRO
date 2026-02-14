<x-app-layout>
    @php
        $u = $u ?? Auth::user();
        $r = $u->rechercheur;
        $formations = $r?->formations ?? collect();
        $experiences = $r?->experiences ?? collect();
        $skills = $r?->skills ?? collect();
    @endphp

    {{-- Background Atmosphere --}}
    <div class="fixed inset-0 -z-10 overflow-hidden pointer-events-none">
        <div class="absolute top-0 right-0 w-full h-[600px] bg-gradient-to-b from-indigo-50/50 to-transparent"></div>
        <div class="absolute -top-[10%] -left-[10%] w-[40%] h-[40%] rounded-full bg-indigo-100/40 blur-[100px] mix-blend-multiply"></div>
        <div class="absolute top-[20%] -right-[5%] w-[35%] h-[35%] rounded-full bg-emerald-50/40 blur-[100px] mix-blend-multiply"></div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 space-y-8">
        
        {{-- Header Section --}}
        <div class="relative rounded-[2.5rem] bg-slate-900 overflow-hidden shadow-2xl shadow-indigo-900/20">
            <div class="absolute inset-0">
                <div class="absolute inset-0 bg-gradient-to-r from-indigo-600 to-emerald-600 opacity-90"></div>
                <div class="absolute -top-24 -right-24 w-96 h-96 bg-white/10 blur-3xl rounded-full"></div>
                <div class="absolute -bottom-24 -left-24 w-72 h-72 bg-emerald-400/20 blur-3xl rounded-full"></div>
                <svg class="absolute inset-0 w-full h-full opacity-10" viewBox="0 0 100 100" preserveAspectRatio="none">
                     <path d="M0 100 C 20 0 50 0 100 100 Z" fill="white"></path>
                </svg>
            </div>
            
            <div class="relative p-8 md:p-12 flex flex-col md:flex-row items-center gap-8 text-center md:text-left">
                <div class="relative group">
                    <div class="absolute -inset-1 bg-gradient-to-r from-pink-500 to-violet-500 rounded-3xl blur opacity-30 group-hover:opacity-75 transition duration-500"></div>
                    <div class="relative h-28 w-28 rounded-3xl bg-white p-1 shadow-xl">
                        <img src="{{ $u->image ?? 'https://i.pravatar.cc/150?img=3' }}" 
                             class="h-full w-full rounded-2xl object-cover" 
                             alt="Avatar">
                    </div>
                </div>
                
                <div class="flex-1 text-white">
                    <div class="flex items-center justify-center md:justify-start gap-3 mb-2">
                        <h1 class="text-3xl font-black tracking-tight">{{ $u->prenom }} {{ $u->nom }}</h1>
                        @php $plan = $u->currentPlan(); @endphp
                        @if($plan === 'Professional')
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-black bg-amber-400 text-amber-900 shadow-lg shadow-amber-500/20">PRO</span>
                        @elseif($plan === 'Business')
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-black bg-white text-slate-900 shadow-lg">BIZ</span>
                        @endif
                    </div>
                    <p class="text-indigo-100 text-lg font-medium mb-4 max-w-2xl">
                        {{ $r->titre_profil ?? 'Aucun titre défini' }} &bull; {{ $r->specialite ?? 'Spécialité non définie' }}
                    </p>
                    <div class="flex items-center justify-center md:justify-start gap-4 text-sm font-medium text-indigo-50/80">
                        <span class="flex items-center gap-1.5">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                            {{ $u->email }}
                        </span>
                        @if($r->ville)
                        <span class="flex items-center gap-1.5">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                            {{ $r->ville }}
                        </span>
                        @endif
                    </div>
                </div>

                <div class="flex flex-col gap-3 min-w-[140px]">
                     <a href="{{ route('rechercheur.profile.edit') }}" 
                       class="rounded-xl px-6 py-3 bg-white/10 backdrop-blur-md border border-white/20 text-white font-bold hover:bg-white/20 transition-all text-sm shadow-lg">
                        👀 Voir mon profil public
                    </a>
                </div>
            </div>
        </div>

        @if(session('status'))
            <div class="rounded-3xl border border-emerald-200 bg-emerald-50 p-4 flex items-center gap-3 text-sm font-bold text-emerald-800 shadow-sm animate-in fade-in slide-in-from-top-2">
                <svg class="h-5 w-5 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                {{ session('status') }}
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
            
            {{-- Main Content --}}
            <div class="lg:col-span-8 space-y-8">
                
                {{-- 1. Informations Personnelles --}}
                <div class="bg-white rounded-[2rem] border border-slate-200 p-8 shadow-xl shadow-slate-200/50">
                    <div class="flex items-center gap-4 mb-6">
                        <div class="p-3 rounded-2xl bg-indigo-50 text-indigo-600">
                            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
                        </div>
                        <div>
                            <h2 class="text-xl font-black text-slate-900">Informations Personnelles</h2>
                            <p class="text-sm text-slate-500 font-medium">Vos coordonnées et votre présentation</p>
                        </div>
                    </div>

                    <form method="POST" action="{{ route('rechercheur.profile.update') }}" class="space-y-6">
                        @csrf
                        @method('PATCH')

                        <div class="grid md:grid-cols-2 gap-6">
                            <div class="space-y-2">
                                <label class="text-xs font-bold uppercase tracking-wider text-slate-500 ml-1">Prénom</label>
                                <input name="prenom" value="{{ old('prenom', $u->prenom) }}" class="w-full rounded-xl border-slate-200 bg-slate-50 px-4 py-3 text-sm font-semibold focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-shadow">
                            </div>
                            <div class="space-y-2">
                                <label class="text-xs font-bold uppercase tracking-wider text-slate-500 ml-1">Nom</label>
                                <input name="nom" value="{{ old('nom', $u->nom) }}" class="w-full rounded-xl border-slate-200 bg-slate-50 px-4 py-3 text-sm font-semibold focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-shadow">
                            </div>
                        </div>

                         <div class="space-y-2">
                            <label class="text-xs font-bold uppercase tracking-wider text-slate-500 ml-1">Titre du profil</label>
                            <input name="titre_profil" value="{{ old('titre_profil', $r->titre_profil ?? '') }}" placeholder="Ex: Développeur Full Stack Senior" class="w-full rounded-xl border-slate-200 bg-slate-50 px-4 py-3 text-sm font-semibold focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-shadow">
                        </div>

                        <div class="space-y-2">
                            <label class="text-xs font-bold uppercase tracking-wider text-slate-500 ml-1">Biographie</label>
                            <textarea name="biographie" rows="4" class="w-full rounded-xl border-slate-200 bg-slate-50 px-4 py-3 text-sm font-medium focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-shadow" placeholder="Parlez de vous, de vos passions et de ce que vous recherchez...">{{ old('biographie', $u->biographie) }}</textarea>
                        </div>

                        <div class="grid md:grid-cols-2 gap-6">
                            <div class="space-y-2">
                                <label class="text-xs font-bold uppercase tracking-wider text-slate-500 ml-1">Spécialité</label>
                                <input name="specialite" value="{{ old('specialite', $r->specialite ?? '') }}" placeholder="Ex: Laravel, React, Vue.js" class="w-full rounded-xl border-slate-200 bg-slate-50 px-4 py-3 text-sm font-semibold focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-shadow">
                            </div>
                            <div class="space-y-2">
                                <label class="text-xs font-bold uppercase tracking-wider text-slate-500 ml-1">Ville</label>
                                <input name="ville" value="{{ old('ville', $r->ville ?? '') }}" placeholder="Ex: Casablanca" class="w-full rounded-xl border-slate-200 bg-slate-50 px-4 py-3 text-sm font-semibold focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-shadow">
                            </div>
                        </div>
                        
                        <div class="space-y-2">
                             <label class="text-xs font-bold uppercase tracking-wider text-slate-500 ml-1">Photo de profil (URL)</label>
                             <input name="image" value="{{ old('image', $u->image) }}" placeholder="https://..." class="w-full rounded-xl border-slate-200 bg-slate-50 px-4 py-3 text-sm font-medium text-slate-600 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-shadow">
                        </div>

                         <div class="space-y-2 hidden">
                             <label class="text-xs font-bold uppercase tracking-wider text-slate-500 ml-1">Rôle</label>
                             <select name="role" class="w-full rounded-xl border-slate-200 bg-slate-50 px-4 py-3 text-sm font-semibold">
                                <option value="RECHERCHEUR" selected>Chercheur</option>
                            </select>
                        </div>

                        <div class="pt-4 flex justify-end">
                            <button type="submit" class="bg-slate-900 text-white rounded-xl px-8 py-3.5 font-bold text-sm shadow-lg shadow-slate-900/20 hover:bg-indigo-600 hover:shadow-indigo-600/30 transition-all hover:scale-105 active:scale-95">
                                Enregistrer les modifications
                            </button>
                        </div>
                    </form>
                </div>

                {{-- 2. Expériences --}}
                <div class="bg-white rounded-[2rem] border border-slate-200 p-8 shadow-xl shadow-slate-200/50">
                     <div class="flex items-center justify-between gap-4 mb-8">
                        <div class="flex items-center gap-4">
                            <div class="p-3 rounded-2xl bg-emerald-50 text-emerald-600">
                                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" /></svg>
                            </div>
                            <div>
                                <h2 class="text-xl font-black text-slate-900">Expériences Pro</h2>
                                <p class="text-sm text-slate-500 font-medium">Votre parcours professionnel</p>
                            </div>
                        </div>
                        <span class="bg-slate-100 text-slate-600 px-3 py-1 rounded-full text-xs font-bold">{{ $experiences->count() }}</span>
                    </div>

                    <div class="space-y-8">
                        {{-- Add Form --}}
                         <div class="bg-slate-50 rounded-2xl p-6 border border-slate-100">
                            <form method="POST" action="{{ route('rechercheur.experiences.store') }}" class="grid gap-4 sm:grid-cols-2">
                                @csrf
                                <input name="poste" placeholder="Poste occupé" class="rounded-xl border-slate-200 bg-white px-4 py-3 text-sm font-semibold focus:ring-emerald-500 focus:border-emerald-500">
                                <input name="entreprise" placeholder="Nom de l'entreprise" class="rounded-xl border-slate-200 bg-white px-4 py-3 text-sm font-semibold focus:ring-emerald-500 focus:border-emerald-500">
                                <div class="grid grid-cols-2 gap-2 sm:col-span-2">
                                    <input type="date" name="date_debut" class="rounded-xl border-slate-200 bg-white px-4 py-3 text-sm font-medium focus:ring-emerald-500 focus:border-emerald-500">
                                    <input type="date" name="date_fin" class="rounded-xl border-slate-200 bg-white px-4 py-3 text-sm font-medium focus:ring-emerald-500 focus:border-emerald-500">
                                </div>
                                
                                <label class="flex items-center gap-2 text-sm font-bold text-slate-600 sm:col-span-2 cursor-pointer">
                                    <input type="checkbox" name="en_poste" value="1" class="rounded border-slate-300 text-emerald-600 focus:ring-emerald-500">
                                    Je travaille ici actuellement
                                </label>

                                <textarea name="description" rows="2" placeholder="Description des missions..." class="sm:col-span-2 rounded-xl border-slate-200 bg-white px-4 py-3 text-sm font-medium focus:ring-emerald-500 focus:border-emerald-500"></textarea>

                                <div class="sm:col-span-2 flex justify-end">
                                    <button class="bg-emerald-600 text-white rounded-xl px-6 py-2.5 font-bold text-sm shadow-lg shadow-emerald-500/30 hover:bg-emerald-700 hover:scale-105 active:scale-95 transition-all">
                                        + Ajouter une expérience
                                    </button>
                                </div>
                            </form>
                         </div>

                         {{-- List --}}
                         <div class="space-y-4">
                            @foreach($experiences as $e)
                                <div class="group relative bg-white rounded-2xl border border-slate-200 p-6 hover:shadow-lg hover:border-emerald-200 transition-all">
                                     <form method="POST" action="{{ route('rechercheur.experiences.update', $e->id) }}">
                                        @csrf
                                        @method('PATCH')
                                        <div class="grid md:grid-cols-2 gap-4">
                                            <div class="space-y-4">
                                                <input name="poste" value="{{ $e->poste }}" class="w-full font-bold text-lg text-slate-900 bg-transparent border-0 border-b border-dashed border-slate-300 focus:ring-0 focus:border-emerald-500 p-0 pb-1">
                                                <input name="entreprise" value="{{ $e->entreprise }}" class="w-full font-semibold text-slate-600 bg-transparent border-0 border-b border-dashed border-slate-300 focus:ring-0 focus:border-emerald-500 p-0 pb-1 text-sm">
                                            </div>
                                            <div class="space-y-3">
                                                <div class="flex gap-2">
                                                    <input type="date" name="date_debut" value="{{ optional($e->date_debut)->format('Y-m-d') }}" class="w-full text-xs font-bold text-slate-500 bg-slate-50 rounded-lg border-0 p-2">
                                                    <input type="date" name="date_fin" value="{{ optional($e->date_fin)->format('Y-m-d') }}" class="w-full text-xs font-bold text-slate-500 bg-slate-50 rounded-lg border-0 p-2">
                                                </div>
                                                <label class="flex items-center gap-2 text-xs font-bold text-slate-500">
                                                    <input type="checkbox" name="en_poste" value="1" @checked($e->en_poste) class="rounded border-slate-300 text-emerald-600">
                                                    En poste
                                                </label>
                                            </div>
                                            <div class="md:col-span-2">
                                                <textarea name="description" rows="2" class="w-full text-sm text-slate-600 bg-slate-50 rounded-xl border-0 p-3 focus:ring-2 focus:ring-emerald-500">{{ $e->description }}</textarea>
                                            </div>
                                        </div>
                                        
                                        <div class="mt-4 flex items-center justify-end gap-2 opacity-0 group-hover:opacity-100 transition-opacity">
                                             <button type="submit" class="text-xs font-bold text-emerald-600 hover:text-emerald-800 bg-emerald-50 px-3 py-1.5 rounded-lg">
                                                Sauvegarder
                                            </button>
                                       </form>
                                       <form method="POST" action="{{ route('rechercheur.experiences.destroy', $e->id) }}">
                                            @csrf @method('DELETE')
                                            <button class="text-xs font-bold text-rose-600 hover:text-rose-800 bg-rose-50 px-3 py-1.5 rounded-lg">
                                                Supprimer
                                            </button>
                                       </form>
                                       </div>
                                </div>
                            @endforeach
                         </div>
                    </div>
                </div>

                {{-- 3. Formations --}}
                <div class="bg-white rounded-[2rem] border border-slate-200 p-8 shadow-xl shadow-slate-200/50">
                     <div class="flex items-center justify-between gap-4 mb-8">
                        <div class="flex items-center gap-4">
                            <div class="p-3 rounded-2xl bg-indigo-50 text-indigo-600">
                                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path d="M12 14l9-5-9-5-9 5 9 5z" /><path d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14zm-4 6v-7.5l4-2.222" /></svg>
                            </div>
                            <div>
                                <h2 class="text-xl font-black text-slate-900">Formations</h2>
                                <p class="text-sm text-slate-500 font-medium">Vos diplômes et certificats</p>
                            </div>
                        </div>
                        <span class="bg-slate-100 text-slate-600 px-3 py-1 rounded-full text-xs font-bold">{{ $formations->count() }}</span>
                    </div>

                     <div class="space-y-8">
                        {{-- Add Form --}}
                         <div class="bg-slate-50 rounded-2xl p-6 border border-slate-100">
                            <form method="POST" action="{{ route('rechercheur.formations.store') }}" class="grid gap-4 sm:grid-cols-2">
                                @csrf
                                <input name="diplome" placeholder="Diplôme obtenu" class="rounded-xl border-slate-200 bg-white px-4 py-3 text-sm font-semibold focus:ring-indigo-500 focus:border-indigo-500">
                                <input name="ecole" placeholder="École / Université" class="rounded-xl border-slate-200 bg-white px-4 py-3 text-sm font-semibold focus:ring-indigo-500 focus:border-indigo-500">
                                <input name="annee_obtention" placeholder="Année (ex: 2024)" class="rounded-xl border-slate-200 bg-white px-4 py-3 text-sm font-medium focus:ring-indigo-500 focus:border-indigo-500">
                                <input name="description" placeholder="Détails..." class="rounded-xl border-slate-200 bg-white px-4 py-3 text-sm font-medium focus:ring-indigo-500 focus:border-indigo-500">
                        
                                <div class="sm:col-span-2 flex justify-end">
                                    <button class="bg-indigo-600 text-white rounded-xl px-6 py-2.5 font-bold text-sm shadow-lg shadow-indigo-500/30 hover:bg-indigo-700 hover:scale-105 active:scale-95 transition-all">
                                        + Ajouter une formation
                                    </button>
                                </div>
                            </form>
                         </div>

                         {{-- List --}}
                         <div class="space-y-4">
                            @foreach($formations as $f)
                                <div class="group relative bg-white rounded-2xl border border-slate-200 p-6 hover:shadow-lg hover:border-indigo-200 transition-all">
                                     <form method="POST" action="{{ route('rechercheur.formations.update', $f->id) }}">
                                        @csrf @method('PATCH')
                                        <div class="grid md:grid-cols-2 gap-4">
                                            <div class="space-y-4">
                                                <input name="diplome" value="{{ $f->diplome }}" class="w-full font-bold text-lg text-slate-900 bg-transparent border-0 border-b border-dashed border-slate-300 focus:ring-0 focus:border-indigo-500 p-0 pb-1">
                                                <input name="ecole" value="{{ $f->ecole }}" class="w-full font-semibold text-slate-600 bg-transparent border-0 border-b border-dashed border-slate-300 focus:ring-0 focus:border-indigo-500 p-0 pb-1 text-sm">
                                            </div>
                                            <div class="space-y-3">
                                                 <input name="annee_obtention" value="{{ $f->annee_obtention }}" class="w-full text-xs font-bold text-slate-500 bg-slate-50 rounded-lg border-0 p-2 text-center">
                                                 <input name="description" value="{{ $f->description }}" placeholder="Description" class="w-full text-sm text-slate-600 bg-slate-50 rounded-lg border-0 p-2">
                                            </div>
                                        </div>
                                         <div class="mt-4 flex items-center justify-end gap-2 opacity-0 group-hover:opacity-100 transition-opacity">
                                             <button type="submit" class="text-xs font-bold text-indigo-600 hover:text-indigo-800 bg-indigo-50 px-3 py-1.5 rounded-lg">
                                                Sauvegarder
                                            </button>
                                       </form>
                                       <form method="POST" action="{{ route('rechercheur.formations.destroy', $f->id) }}">
                                            @csrf @method('DELETE')
                                            <button class="text-xs font-bold text-rose-600 hover:text-rose-800 bg-rose-50 px-3 py-1.5 rounded-lg">
                                                Supprimer
                                            </button>
                                       </form>
                                       </div>
                                </div>
                            @endforeach
                         </div>
                    </div>
                </div>

            </div>

            {{-- Sidebar --}}
            <div class="lg:col-span-4 space-y-8">
                 {{-- Compétences --}}
                <div class="bg-white rounded-[2rem] border border-slate-200 p-6 shadow-xl shadow-slate-200/50 sticky top-24">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="p-2.5 rounded-xl bg-violet-50 text-violet-600">
                             <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" /></svg>
                        </div>
                         <h2 class="text-lg font-black text-slate-900">Compétences</h2>
                    </div>

                    <form method="POST" action="{{ route('rechercheur.skills.attach') }}" class="space-y-3 mb-6">
                        @csrf
                        <div class="grid grid-cols-2 gap-2">
                             <input name="skill_name" placeholder="Ex: React" class="col-span-2 w-full rounded-xl border-slate-200 bg-slate-50 px-4 py-2.5 text-sm font-medium focus:ring-violet-500 focus:border-violet-500">
                             <select name="niveau" class="col-span-2 w-full rounded-xl border-slate-200 bg-slate-50 px-4 py-2.5 text-sm font-medium focus:ring-violet-500 focus:border-violet-500">
                                <option value="">Niveau</option>
                                <option value="DEBUTANT">Débutant</option>
                                <option value="INTERMEDIAIRE">Intermédiaire</option>
                                <option value="AVANCE">Avancé</option>
                                <option value="EXPERT">Expert</option>
                            </select>
                        </div>
                        <button class="w-full bg-violet-600 text-white rounded-xl py-2.5 font-bold text-sm shadow-md shadow-violet-500/30 hover:bg-violet-700 transition-all">
                            Ajouter
                        </button>
                    </form>

                     <div class="space-y-3">
                        @foreach($skills as $s)
                             <div class="group flex items-center justify-between p-3 rounded-2xl bg-white border border-slate-200 hover:border-violet-300 transition-colors">
                                <div class="min-w-0">
                                    <div class="font-bold text-slate-800 leading-tight">{{ $s->nom }}</div>
                                    <div class="text-[10px] font-bold uppercase tracking-wider text-violet-600 mt-1">{{ $s->pivot->niveau }}</div>
                                </div>
                                <form method="POST" action="{{ route('rechercheur.skills.detach', $s->id) }}">
                                    @csrf @method('DELETE')
                                    <button class="p-1.5 text-slate-300 hover:text-rose-500 transition-colors">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                                    </button>
                                </form>
                            </div>
                        @endforeach
                     </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
