@props([
    'active' => 'dashboard', 
    'user'   => auth()->user(),
])       
    <a href="{{ route('dashboard.rechercheur') }}"
       class="px-3 py-1.5 rounded-full text-sm font-semibold transition-all duration-200 {{ request()->routeIs('dashboard.*')
            ? 'bg-white text-indigo-600 shadow-sm ring-1 ring-black/5'
            : 'text-slate-500 hover:text-slate-900 hover:bg-white/50' }}">
        Dashboard
    </a>
    <a href="{{ route('offers.rechercheurs.index') }}"
       class="px-3 py-1.5 rounded-full text-sm font-semibold transition-all duration-200 {{ request()->routeIs('offers.*')
            ? 'bg-white text-indigo-600 shadow-sm ring-1 ring-black/5'
            : 'text-slate-500 hover:text-slate-900 hover:bg-white/50' }}">
        Offres
    </a>

    <a href="{{route('users.search')}}"
       class="px-3 py-1.5 rounded-full text-sm font-semibold transition-all duration-200 {{ request()->routeIs('users.search')
            ? 'bg-white text-indigo-600 shadow-sm ring-1 ring-black/5'
            : 'text-slate-500 hover:text-slate-900 hover:bg-white/50' }}">
        Recherche
    </a>


    <a href="{{route('profile.manage')}}"
       class="px-3 py-1.5 rounded-full text-sm font-semibold transition-all duration-200 {{ request()->routeIs('profile.*') || request()->routeIs('rechercheur.profile.*')
            ? 'bg-white text-indigo-600 shadow-sm ring-1 ring-black/5'
            : 'text-slate-500 hover:text-slate-900 hover:bg-white/50' }}">
        Profil
    </a>

    <a href="{{route('friends.index')}}"
       class="px-3 py-1.5 rounded-full text-sm font-semibold transition-all duration-200 {{ request()->routeIs('friends.*')
            ? 'bg-white text-indigo-600 shadow-sm ring-1 ring-black/5'
            : 'text-slate-500 hover:text-slate-900 hover:bg-white/50' }}">
        Amis
    </a>

    <!-- Notifications Removed (Already in top bar) -->

    <a href="{{ route('chat.index') }}"
       class="px-3 py-1.5 rounded-full text-sm font-semibold transition-all duration-200 {{ request()->routeIs('chat.*')
            ? 'bg-white text-indigo-600 shadow-sm ring-1 ring-black/5'
            : 'text-slate-500 hover:text-slate-900 hover:bg-white/50' }}">
        Messagerie
    </a>

    <a href="{{ route('premium') }}"
       class="ml-2 px-3 py-1.5 rounded-full border border-transparent transition-all duration-200 group {{ request()->routeIs('premium')
            ? 'bg-gradient-to-r from-indigo-600 to-purple-600 text-white shadow-md'
            : 'hover:bg-white/50' }}">
        <div class="flex items-center space-x-1.5">
             <span class="{{ request()->routeIs('premium') ? 'text-white' : 'text-transparent bg-clip-text bg-gradient-to-r from-indigo-500 to-purple-600 font-bold group-hover:opacity-80' }}">
                Premium
            </span>
            @if(auth()->user()->subscribed('default'))
                <span class="inline-flex items-center px-1.5 py-0.5 rounded text-[10px] uppercase font-bold {{ request()->routeIs('premium') ? 'bg-white/20 text-white' : 'bg-indigo-100 text-indigo-800' }}">
                    PRO
                </span>
            @else
               <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 {{ request()->routeIs('premium') ? 'text-white' : 'text-amber-500' }}" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M5 2a1 1 0 011 1v1h1a1 1 0 010 2H6v1a1 1 0 01-2 0V6H3a1 1 0 010-2h1V3a1 1 0 011-1zm0 5a1 1 0 011 1v3.286l.293.293a1 1 0 01-1.414 1.414l-2-2a1 1 0 010-1.414l2-2a1 1 0 011.414 0l.293.293V8a1 1 0 011-1z" clip-rule="evenodd" />
                    <path d="M10 2a1 1 0 011 1v1.323l3.954 1.582 1.599-.8a1 1 0 01.894 1.79l-1.233.616 1.738 5.42a1 1 0 01-1.4 1.252l-6.6 1.76a1 1 0 01-1.252-1.4l1.76-6.6 5.42 1.738-.616-1.233a1 1 0 011.79-.894l-.8 1.599L11 4.323V3a1 1 0 011-1z" />
                </svg>
            @endif
        </div>
    </a>