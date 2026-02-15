<x-app-layout>
    <div class="h-[calc(100vh-65px)] overflow-hidden bg-slate-50 flex" data-user-id="{{ auth()->id() }}">
        <!-- Background Elements (Subtle) -->
        <div class="fixed inset-0 pointer-events-none z-0">
            <div class="absolute top-20 left-10 w-96 h-96 bg-indigo-200/20 rounded-full blur-3xl opacity-50 mix-blend-multiply"></div>
            <div class="absolute bottom-10 right-10 w-96 h-96 bg-purple-200/20 rounded-full blur-3xl opacity-50 mix-blend-multiply"></div>
        </div>

        <!-- Sidebar -->
        <div class="w-full md:w-[380px] bg-white/80 backdrop-blur-xl border-r border-slate-200/60 flex flex-col z-10 relative shadow-[4px_0_24px_rgba(0,0,0,0.02)]">
            <!-- Header & Search -->
            <div class="p-6 border-b border-slate-100">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-2xl font-black text-slate-900 tracking-tight">Messages</h2>
                    <div class="flex gap-2">
                        <a href="{{ route('chat.index', ['type' => 'active']) }}" class="px-4 py-2 text-xs font-bold rounded-xl transition-all {{ request('type', 'active') == 'active' ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-200' : 'text-slate-500 hover:bg-slate-100' }}">Discussions</a>
                        <a href="{{ route('chat.index', ['type' => 'archived']) }}" class="px-4 py-2 text-xs font-bold rounded-xl transition-all {{ request('type') == 'archived' ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-200' : 'text-slate-500 hover:bg-slate-100' }}">Archives</a>
                    </div>
                </div>
                
                <form action="{{ route('chat.index') }}" method="GET" class="relative group">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-4 transition-colors group-focus-within:text-indigo-500 text-slate-400">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
                    </span>
                    <input type="text" name="q" value="{{ request('q') }}" placeholder="Rechercher une discussion..."
                        class="w-full py-3.5 pl-11 pr-4 bg-slate-50/50 border border-slate-200/60 rounded-2xl text-sm font-medium focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 focus:bg-white transition-all placeholder-slate-400 text-slate-900 shadow-sm">
                </form>

                <!-- Filter Tabs (Active / Archived) -->
                <div class="flex items-center gap-1 mt-6 p-1 bg-slate-100/80 rounded-xl">
                    <a href="{{ route('chat.index', ['type' => 'active']) }}" 
                       class="flex-1 py-1.5 text-center text-xs font-bold rounded-lg transition-all {{ request('type', 'active') == 'active' ? 'bg-white text-slate-900 shadow-sm' : 'text-slate-500 hover:text-slate-700' }}">
                       Actifs
                    </a>
                    <a href="{{ route('chat.index', ['type' => 'archived']) }}" 
                       class="flex-1 py-1.5 text-center text-xs font-bold rounded-lg transition-all {{ request('type') == 'archived' ? 'bg-white text-slate-900 shadow-sm' : 'text-slate-500 hover:text-slate-700' }}">
                       Archivés
                    </a>
                </div>
            </div>

            <div class="flex-1 overflow-y-auto px-4 pb-4 space-y-2 custom-scrollbar">
                @forelse ($conversations as $conv)
                    @php
                        $friend = ($conv->user_one_id == auth()->id()) ? $conv->userTow : $conv->userOne;
                        $isSelected = isset($conversation) && $conversation->id === $conv->id;
                    @endphp
                    <a href="{{ route('chat.show', $conv->id) }}" data-con-id="{{ $conv->id }}"
                        class="group relative flex items-center gap-4 p-4 rounded-[1.2rem] transition-all duration-300 border border-transparent
                               {{ $isSelected 
                                    ? 'bg-indigo-50/80 border-indigo-100/50 shadow-sm' 
                                    : 'hover:bg-slate-50 hover:border-slate-100' }}">
                        
                        <!-- Avatar -->
                        <div class="relative flex-shrink-0" data-ui="avatar-container">
                            <div class="w-12 h-12 rounded-[1rem] p-0.5 bg-gradient-to-br {{ $isSelected ? 'from-indigo-500 to-purple-500' : 'from-slate-100 to-slate-200 group-hover:from-indigo-200 group-hover:to-purple-200' }} transition-all">
                                <img src="{{ $friend->image ?? 'https://i.pravatar.cc/150?u='.$friend->id }}" 
                                     alt="{{ $friend->nom }}" 
                                     class="w-full h-full rounded-[0.9rem] object-cover bg-white">
                            </div>
                            
                            <!-- Online Status -->
                            <span class="absolute -bottom-1 -right-1 flex h-4 w-4">
                                <span class="relative inline-flex rounded-full h-4 w-4 {{ App\Helpers\UserHelper::isUserOnline($friend->id) ? 'bg-emerald-500' : 'bg-slate-300' }} border-2 border-white transition-colors duration-300" data-user-status="{{ $friend->id }}"></span>
                            </span>

                            @if($conv->unread_count > 0)
                                <div class="absolute -top-2 -left-2" data-ui="unread-badge">
                                    <span class="flex h-5 w-5 relative">
                                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-rose-400 opacity-75"></span>
                                        <span class="relative inline-flex rounded-full h-5 w-5 bg-gradient-to-r from-rose-500 to-pink-600 text-white text-[10px] font-black items-center justify-center border-2 border-white shadow-sm" data-ui="unread-count">{{ $conv->unread_count }}</span>
                                    </span>
                                </div>
                            @endif
                        </div>

                        <!-- Content -->
                        <div class="flex-1 min-w-0">
                            <div class="flex justify-between items-center mb-0.5" data-ui="item-header">
                                <h3 class="text-sm font-bold {{ $isSelected ? 'text-indigo-900' : 'text-slate-900' }} truncate">
                                    {{ $friend->nom }} <span class="font-medium opacity-80">{{ $friend->prenom }}</span>
                                </h3>
                                @if($conv->lastMessage)
                                    <span class="text-[10px] font-medium text-slate-400 flex-shrink-0" data-ui="time-display">{{ $conv->lastMessage->created_at->format('H:i') }}</span>
                                @endif
                            </div>
                            
                            <div class="flex items-center justify-between">
                                <p class="text-xs {{ $isSelected ? 'text-indigo-700 font-medium' : 'text-slate-500' }} truncate pr-2 opacity-90" data-ui="message-preview">
                                    @if($conv->lastMessage)
                                        @if($conv->lastMessage->sender_id == auth()->id())
                                            <span class="{{ $isSelected ? 'text-indigo-500' : 'text-slate-400' }}">Vous:</span>
                                        @endif
                                        @if($conv->lastMessage->text)
                                            {{ Str::limit($conv->lastMessage->text, 25) }}
                                        @elseif(!empty($conv->lastMessage->attach))
                                            <span class="flex items-center gap-1 italic"><svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13" /></svg> Fichier</span>
                                        @endif
                                    @else
                                        <span class="italic opacity-60">Nouvelle discussion</span>
                                    @endif
                                </p>
                                
                                </div>
                                </div>
                            </div>
                        </div>

                         <!-- Dropdown Menu -->
                         <div id="dropdown-{{ $conv->id }}" class="hidden absolute right-4 top-14 z-50 w-40 bg-white rounded-xl shadow-[0_10px_40px_rgba(0,0,0,0.1)] border border-slate-100 py-1 text-xs font-semibold origin-top-right animate-in fade-in zoom-in-95 duration-200">
                            @if(request('type') == 'archived')
                                <form action="{{ route('chat.unarchive', $conv->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="w-full text-left px-4 py-2.5 text-slate-700 hover:bg-slate-50 hover:text-indigo-600 transition-colors flex items-center gap-2">
                                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 19a2 2 0 01-2-2V7a2 2 0 012-2h4l2 2h4a2 2 0 012 2v1M5 19h14a2 2 0 002-2v-5a2 2 0 00-2-2H9a2 2 0 00-2 2v5a2 2 0 01-2 2z" /></svg>
                                        Désarchiver
                                    </button>
                                </form>
                            @else
                                <form action="{{ route('chat.archive', $conv->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="w-full text-left px-4 py-2.5 text-slate-700 hover:bg-slate-50 hover:text-indigo-600 transition-colors flex items-center gap-2">
                                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4" /></svg>
                                        Archiver
                                    </button>
                                </form>
                            @endif
                            <div class="h-px bg-slate-100 my-1"></div>
                            <form action="{{ route('chat.delete', $conv->id) }}" method="POST">
                                @csrf @method('DELETE')
                                <button type="submit" class="w-full text-left px-4 py-2.5 text-rose-600 hover:bg-rose-50 transition-colors flex items-center gap-2" onclick="return confirm('Supprimer définitivement cette conversation ?')">
                                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                    Supprimer
                                </button>
                            </form>
                        </div>
                    </a>
                @empty
                    <div class="flex flex-col items-center justify-center py-10 px-4 text-center">
                        <div class="w-16 h-16 bg-slate-100 rounded-2xl flex items-center justify-center mb-4 text-slate-300">
                           <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" /></svg>
                        </div>
                        <p class="text-sm font-bold text-slate-800">Aucune discussion</p>
                        <p class="text-xs text-slate-500 mt-1 mb-4">Votre boîte de réception est vide.</p>
                        <a href="{{ route('friends.index') }}"
                            class="px-4 py-2 bg-indigo-600 text-white text-xs font-bold rounded-xl shadow-lg shadow-indigo-500/30 hover:bg-indigo-700 transition-all hover:scale-105 active:scale-95">
                            Nouvelle discussion
                        </a>
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Chat Area -->
        <div class="flex-1 flex flex-col relative z-0">
            @if($selected_user)
                <!-- Header -->
                <div class="px-6 py-4 bg-white/60 backdrop-blur-md border-b border-white shadow-sm flex items-center justify-between z-10">
                    <div class="flex items-center gap-4">
                        <div class="relative group cursor-pointer">
                            <div class="absolute -inset-0.5 bg-gradient-to-tr from-indigo-500 to-purple-500 rounded-full opacity-0 group-hover:opacity-100 transition duration-500 blur-sm"></div>
                            <img src="{{$selected_user->image }}" alt="{{ $selected_user->prenom  }}" class="relative w-11 h-11 rounded-full object-cover border-2 border-white shadow-sm">
                             <!-- Online Status -->
                            <span class="absolute bottom-0 right-0 block h-3 w-3 rounded-full {{ App\Helpers\UserHelper::isUserOnline($selected_user->id) ? 'bg-emerald-500' : 'bg-slate-300' }} ring-2 ring-white transition-colors duration-300" data-user-status="{{ $selected_user->id }}"></span>
                        </div>
                        
                        <div class="flex flex-col">
                            <h3 class="text-lg font-black text-slate-900 leading-tight">
                                {{  $selected_user->prenom . ' ' . $selected_user->nom  }}
                            </h3>
                            
                            <div class="flex items-center h-4">
                                <p id="typing-indicator" class="text-xs text-indigo-600 font-bold hidden animate-pulse bg-indigo-50 px-2 py-0.5 rounded-full">
                                    écrit...
                                </p>
                                <div id="online-status">
                                    @if(App\Helpers\UserHelper::isUserOnline($selected_user->id))
                                        <p class="text-xs text-emerald-600 font-bold">En ligne</p>
                                    @else
                                        <p class="text-xs text-slate-500 font-medium">
                                            {{ App\Helpers\UserHelper::getLastSeen($selected_user) }}
                                        </p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="flex items-center gap-2">
                         <div class="hidden sm:flex items-center gap-1 bg-slate-100 p-1 rounded-xl">
                            <button class="p-2 text-slate-400 hover:text-indigo-600 hover:bg-white hover:shadow-sm rounded-lg transition-all" title="Appel vocal">
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" /></svg>
                            </button>
                            <button class="p-2 text-slate-400 hover:text-indigo-600 hover:bg-white hover:shadow-sm rounded-lg transition-all" title="Appel vidéo">
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.82v6.36a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z" /></svg>
                            </button>
                         </div>
                        <button class="p-2 text-slate-400 hover:text-slate-600 hover:bg-slate-100 rounded-full transition-all">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z" /></svg>
                        </button>
                    </div>
                </div>

                <!-- Messages -->
                <div id="messages-container" class="flex-1 overflow-y-auto p-6 space-y-6 scroll-smooth custom-scrollbar">
                    
                    @if(isset($messages))
                        @php
                            $lastDate = null;
                        @endphp
                        @foreach($messages as $message)
                            @php
                                $msgDate = $message->created_at->format('Y-m-d');
                                $displayDate = $message->created_at->isToday() ? "Aujourd'hui" : ($message->created_at->isYesterday() ? "Hier" : $message->created_at->format('d/m/Y'));
                            @endphp

                            @if($lastDate !== $msgDate)
                                <div class="flex justify-center my-6">
                                    <span class="px-4 py-1.5 text-[10px] uppercase font-bold tracking-widest text-slate-400 bg-slate-100 rounded-full shadow-sm">
                                        {{ $displayDate }}
                                    </span>
                                </div>
                                @php $lastDate = $msgDate; @endphp
                            @endif

                            @if($message->sender_id == auth()->id())
                                <!-- MY MESSAGE -->
                                <div class="flex items-end justify-end gap-3 group">
                                    <div class="flex flex-col space-y-1 max-w-lg items-end">
                                        @if(isset($message->attach) && !empty($message->attach['path']))
                                            <div class="mb-1">
                                                @if(Str::startsWith($message->attach['mime_type'], 'image/'))
                                                    <a href="{{ asset('storage/' . $message->attach['path']) }}" target="_blank" class="block overflow-hidden rounded-2xl border-4 border-white shadow-md transition-transform hover:scale-[1.02]">
                                                        <img src="{{ asset('storage/' . $message->attach['path']) }}"
                                                            class="max-w-[240px] max-h-[240px] object-cover">
                                                    </a>
                                                @else
                                                    <a href="{{ asset('storage/' . $message->attach['path']) }}" target="_blank"
                                                        class="flex items-center gap-3 bg-white p-3 rounded-2xl border border-indigo-100 shadow-sm hover:shadow-md transition-all max-w-[240px]">
                                                        <div class="w-10 h-10 bg-indigo-50 rounded-xl flex items-center justify-center text-indigo-500">
                                                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
                                                        </div>
                                                        <div class="flex-1 min-w-0 text-left">
                                                            <p class="text-sm font-bold text-slate-800 truncate">{{ $message->attach['filename'] }}</p>
                                                            <p class="text-[10px] font-medium text-slate-500">{{ number_format($message->attach['size'] / 1024, 1) }} KB</p>
                                                        </div>
                                                    </a>
                                                @endif
                                            </div>
                                        @endif
                                        @if($message->text)
                                            <div class="relative bg-gradient-to-br from-indigo-600 to-violet-600 px-5 py-3.5 rounded-[1.3rem] rounded-br-none shadow-lg shadow-indigo-500/20 text-white text-[15px] leading-relaxed">
                                                {{ $message->text }}
                                            </div>
                                        @endif
                                        <div class="flex items-center gap-1.5 pr-1 opacity-60 group-hover:opacity-100 transition-opacity">
                                            <span class="text-[10px] font-bold text-slate-400">{{ $message->created_at->format('H:i') }}</span>
                                            @if($message->read_at)
                                                <svg class="w-3.5 h-3.5 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                                            @else
                                                 <svg class="w-3.5 h-3.5 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                                            @endif
                                        </div>
                                    </div>
                                    <img src="{{ auth()->user()->image ?? 'https://i.pravatar.cc/150?u=' . auth()->id() }}" 
                                         class="w-8 h-8 rounded-full object-cover shadow-sm ring-2 ring-white self-end mb-6">
                                </div>

                            @else
                                <!-- OTHER MESSAGE -->
                                <div class="flex items-end gap-3 group">
                                    <img src="{{ $selected_user->image ?? 'https://i.pravatar.cc/150?u=' . $selected_user->id }}"
                                         class="w-8 h-8 rounded-full object-cover shadow-sm ring-2 ring-white self-end mb-6">
                                    <div class="flex flex-col space-y-1 max-w-lg">
                                        @if(isset($message->attach) && !empty($message->attach['path']))
                                            <div class="mb-1">
                                                @if(Str::startsWith($message->attach['mime_type'], 'image/'))
                                                    <a href="{{ asset('storage/' . $message->attach['path']) }}" target="_blank" class="block overflow-hidden rounded-2xl border-4 border-white shadow-md transition-transform hover:scale-[1.02]">
                                                        <img src="{{ asset('storage/' . $message->attach['path']) }}"
                                                            class="max-w-[240px] max-h-[240px] object-cover">
                                                    </a>
                                                @else
                                                    <a href="{{ asset('storage/' . $message->attach['path']) }}" target="_blank"
                                                        class="flex items-center gap-3 bg-white p-3 rounded-2xl border border-slate-100 shadow-sm hover:shadow-md transition-all max-w-[240px]">
                                                        <div class="w-10 h-10 bg-slate-100 rounded-xl flex items-center justify-center text-slate-500">
                                                             <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
                                                        </div>
                                                        <div class="flex-1 min-w-0">
                                                            <p class="text-sm font-bold text-slate-800 truncate">{{ $message->attach['filename'] }}</p>
                                                            <p class="text-[10px] font-medium text-slate-500">{{ number_format($message->attach['size'] / 1024, 1) }} KB</p>
                                                        </div>
                                                    </a>
                                                @endif
                                            </div>
                                        @endif
                                        @if($message->text)
                                            <div class="bg-white px-5 py-3.5 rounded-[1.3rem] rounded-bl-none shadow-sm text-slate-800 text-[15px] leading-relaxed border border-slate-100/50">
                                                {{ $message->text }}
                                            </div>
                                        @endif
                                        <div class="flex items-center gap-1.5 pl-1 opacity-60 group-hover:opacity-100 transition-opacity">
                                            <span class="text-[10px] font-bold text-slate-400">{{ $message->created_at->format('H:i') }}</span>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    @endif
                </div>

                <!-- Footer Input -->
                <div class="p-6 bg-transparent absolute bottom-0 w-full z-20 pointer-events-none">
                    <div class="pointer-events-auto">
                        <form id="chat-form" action="{{ route('chat.send') }}" method="POST" enctype="multipart/form-data"
                            class="bg-white/80 backdrop-blur-xl p-2 rounded-[1.5rem] border border-white/50 shadow-[0_-10px_40px_rgba(0,0,0,0.05)] flex items-end gap-2 relative transition-all focus-within:shadow-[0_-10px_50px_rgba(99,102,241,0.15)] focus-within:border-indigo-100">
                            @csrf
                            @if(isset($selected_user))
                                <input type="hidden" name="receiver_id" value="{{ $selected_user->id }}">
                            @endif
                            @if(isset($conversation))
                                <input type="hidden" name="conversation_id" value="{{ $conversation->id }}">
                            @endif

                            <input type="file" name="attachment" id="attachment" class="hidden">
                            <button type="button" onclick="document.getElementById('attachment').click()"
                                class="p-3 text-slate-400 hover:text-indigo-600 hover:bg-indigo-50 rounded-full transition-all duration-200 group relative">
                                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13" /></svg>
                                @if(isset($message) && isset($message->attach)) 
                                    <span class="absolute top-2 right-2 w-2 h-2 bg-rose-500 rounded-full"></span>
                                @endif
                            </button>

                            <div class="flex-1 relative">
                                <!-- File Preview -->
                                <div id="file-preview-container" class="hidden absolute bottom-full left-0 mb-6 w-full">
                                    <div class="bg-white rounded-2xl p-3 border border-indigo-100 shadow-2xl inline-flex items-center gap-4 animate-in slide-in-from-bottom-2 fade-in duration-300">
                                        <div id="preview-icon-wrapper" class="relative group">
                                            <img id="image-preview" src="" class="hidden w-16 h-16 object-cover rounded-xl border-2 border-indigo-100 shadow-sm">
                                            <div id="file-icon" class="hidden w-16 h-16 bg-indigo-50 rounded-xl flex items-center justify-center border-2 border-indigo-100 text-indigo-500">
                                                <svg class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
                                            </div>
                                            <button type="button" id="remove-file" class="absolute -top-2 -right-2 bg-rose-500 text-white rounded-full p-1 shadow-md hover:bg-rose-600 transition transform hover:scale-110 opacity-0 group-hover:opacity-100">
                                                <svg class="h-3 w-3" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" /></svg>
                                            </button>
                                        </div>
                                        <div class="flex flex-col max-w-xs">
                                            <span id="file-name" class="text-sm font-bold text-slate-800 truncate block"></span>
                                            <span id="file-size" class="text-xs text-indigo-500 font-bold"></span>
                                        </div>
                                    </div>
                                </div>

                                <textarea name="message" id="message-input" placeholder="Écrivez votre message..."
                                    class="w-full bg-transparent border-none focus:ring-0 resize-none py-3.5 px-2 text-slate-800 placeholder-slate-400 max-h-32 text-sm font-medium"
                                    rows="1"></textarea>
                            </div>

                            <button type="submit"
                                class="bg-gradient-to-r from-indigo-600 to-violet-600 text-white rounded-full p-3.5 shadow-lg shadow-indigo-500/30 hover:shadow-indigo-500/50 hover:scale-105 active:scale-95 transition-all duration-200 mb-0.5">
                                <svg class="h-5 w-5 transform rotate-90" viewBox="0 0 20 20" fill="currentColor"><path d="M10.894 2.553a1 1 0 00-1.788 0l-7 14a1 1 0 001.169 1.409l5-1.429A1 1 0 009 15.571V11a1 1 0 112 0v4.571a1 1 0 00.725.962l5 1.428a1 1 0 001.17-1.408l-7-14z" /></svg>
                            </button>
                        </form>
                    </div>
                </div>
            @else
                <!-- Empty State -->
                <div class="flex-1 flex flex-col justify-center items-center bg-slate-50 relative overflow-hidden">
                    <div class="absolute inset-0 z-0">
                         <div class="absolute top-1/3 left-1/2 w-[500px] h-[500px] bg-indigo-100/40 rounded-full blur-3xl -translate-x-1/2 -translate-y-1/2"></div>
                    </div>
                    
                    <div class="z-10 text-center p-8 max-w-md animate-in fade-in zoom-in-95 duration-500">
                        <div class="w-24 h-24 bg-white rounded-3xl shadow-xl shadow-indigo-100 flex items-center justify-center mx-auto mb-6 transform rotate-3 hover:rotate-6 transition-transform duration-500">
                            <div class="w-20 h-20 bg-indigo-50 rounded-2xl flex items-center justify-center border border-indigo-100 text-indigo-500">
                                <svg class="h-10 w-10" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" /></svg>
                            </div>
                        </div>
                        <h2 class="text-3xl font-black text-slate-900 mb-3 tracking-tight">Bonjour, {{ auth()->user()->prenom }} !</h2>
                        <p class="text-slate-500 mb-8 leading-relaxed font-medium">Sélectionnez une discussion sur la gauche ou commencez une nouvelle conversation.</p>
                        
                        <a href="{{ route('friends.index') }}"
                            class="inline-flex items-center gap-2 px-6 py-3 bg-slate-900 text-white rounded-2xl font-bold text-sm shadow-xl shadow-slate-900/20 hover:bg-indigo-600 hover:shadow-indigo-500/30 hover:scale-105 active:scale-95 transition-all duration-300">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg>
                            Nouvelle conversation
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {

            let userId = {{ auth()->id() }};
            let conversationId = {{ isset($conversation) ? $conversation->id : 'null' }};

            let form = document.getElementById('chat-form');
            let messagesBox = document.getElementById('messages-container');

            if (messagesBox) {
                messagesBox.scrollTop = messagesBox.scrollHeight;
            }
<<<<<<< HEAD

            function isVue(conversationId) {
                fetch(`/conversations/${conversationId}/isVue`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                });
            }

            if (conversationId) {
                isVue(conversationId);

                // Typing Indicator
                let typingIndicator = document.createElement('div');
                typingIndicator.id = 'typing-indicator';
                typingIndicator.className = 'hidden flex items-end space-x-2 mb-4 ml-2 transition-opacity duration-300 ease-in-out';
                
                let otherUserImage = "{{ isset($selected_user) ? $selected_user->image : 'https://i.pravatar.cc/150' }}";
                
                typingIndicator.innerHTML = `
                    <img src="${otherUserImage}" class="w-8 h-8 rounded-full object-cover shadow-sm mb-1 opacity-70">
                    <div class="bg-gray-100 px-4 py-2 rounded-2xl rounded-bl-none text-xs text-gray-500 font-medium italic flex items-center space-x-1">
                        <span>écrit</span>
                        <span class="flex space-x-1 ml-1">
                            <span class="w-1 h-1 bg-gray-400 rounded-full animate-bounce" style="animation-delay: 0ms"></span>
                            <span class="w-1 h-1 bg-gray-400 rounded-full animate-bounce" style="animation-delay: 150ms"></span>
                            <span class="w-1 h-1 bg-gray-400 rounded-full animate-bounce" style="animation-delay: 300ms"></span>
                        </span>
                    </div>
                `;
                messagesBox.appendChild(typingIndicator);

                let typingTimeout;
                let isTyping = false;

                if (form) {
                    let inputField = form.querySelector('textarea');
                    inputField.addEventListener('input', function() {
                        if (!isTyping) {
                            isTyping = true;
                            fetch(`/conversations/${conversationId}/typing`, {
                                method: "POST",
                                headers: {
                                    "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content,
                                    "Accept": "application/json"
                                }
                            });
                            setTimeout(() => isTyping = false, 2000); 
                        }
                    });
                }

                Echo.private(`conversation.${conversationId}`)
                    .listen('.user.typing', (e) => {
                        if (e.user.id != userId) {
                            let indicator = document.getElementById('typing-indicator');
                            if(indicator){
                                indicator.classList.remove('hidden');
                                messagesBox.scrollTop = messagesBox.scrollHeight;
                                
                                clearTimeout(typingTimeout);
                                typingTimeout = setTimeout(() => {
                                    indicator.classList.add('hidden');
                                }, 3000);
                            }
                        }
                    });
            }

            function addMessage(message) {

                if (!messagesBox) return;

                let indicator = document.getElementById('typing-indicator');
                let isMe = message.sender_id == userId;

                let myImage = "{{ auth()->user()->image ?? 'https://ui-avatars.com/api/?name=' . urlencode(auth()->user()->nom) . '&color=7F9CF5&background=EBF4FF' }}";
                let otherImage = "{{ isset($selected_user) ? ($selected_user->image ?? 'https://ui-avatars.com/api/?name=' . urlencode($selected_user->nom) . '&color=7F9CF5&background=EBF4FF') : '' }}";

                let img = isMe ? myImage : otherImage;

                let html = "";

                if (isMe) {
                    let attachmentHtml = '';
                    if (message.attach && message.attach.path) {
                        let path = "/storage/" + message.attach.path;
                        if (message.attach.mime_type.startsWith('image/')) {
                            attachmentHtml = `
                            <div class="mb-1">
                                <a href="${path}" target="_blank" class="block overflow-hidden rounded-2xl border-4 border-white shadow-md transition-transform hover:scale-[1.02]">
                                    <img src="${path}" class="max-w-[240px] max-h-[240px] object-cover">
                                </a>
                            </div>`;
                        } else {
                            attachmentHtml = `
                            <div class="mb-1">
                                <a href="${path}" target="_blank" class="flex items-center gap-3 bg-white p-3 rounded-2xl border border-indigo-100 shadow-sm hover:shadow-md transition-all max-w-[240px]">
                                    <div class="w-10 h-10 bg-indigo-50 rounded-xl flex items-center justify-center text-indigo-500">
                                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
                                    </div>
                                    <div class="flex-1 min-w-0 text-left">
                                        <p class="text-sm font-bold text-slate-800 truncate">${message.attach.filename}</p>
                                        <p class="text-[10px] font-medium text-slate-500">${(message.attach.size / 1024).toFixed(1)} KB</p>
                                    </div>
                                </a>
                            </div>`;
                        }
                    }

                html = `
                <div class="flex items-end justify-end gap-3 group animate-in slide-in-from-right-5 fade-in duration-300 mb-4">
                    <div class="flex flex-col space-y-1 max-w-lg items-end">
                        ${attachmentHtml}
                        ${message.text ? `<div class="relative bg-gradient-to-br from-indigo-600 to-violet-600 px-5 py-3.5 rounded-[1.3rem] rounded-br-none shadow-lg shadow-indigo-500/20 text-white text-[15px] leading-relaxed">${message.text}</div>` : ''}
                        <div class="flex items-center gap-1.5 pr-1 opacity-60">
                            <span class="text-[10px] font-bold text-slate-400">Maintenant</span>
                             <svg class="w-3.5 h-3.5 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                        </div>
                    </div>
                    <img src="${img}" class="w-8 h-8 rounded-full object-cover shadow-sm ring-2 ring-white self-end mb-6">
                </div>
                `;

                } else {
                    let attachmentHtml = '';
                    if (message.attach && message.attach.path) {
                        let path = "/storage/" + message.attach.path;
                        if (message.attach.mime_type && message.attach.mime_type.startsWith('image/')) {
                            attachmentHtml = `
                            <div class="mb-1">
                                <a href="${path}" target="_blank" class="block overflow-hidden rounded-2xl border-4 border-white shadow-md transition-transform hover:scale-[1.02]">
                                    <img src="${path}" class="max-w-[240px] max-h-[240px] object-cover">
                                </a>
                            </div>`;
                        } else {
                            attachmentHtml = `
                            <div class="mb-1">
                                <a href="${path}" target="_blank" class="flex items-center gap-3 bg-white p-3 rounded-2xl border border-slate-100 shadow-sm hover:shadow-md transition-all max-w-[240px]">
                                    <div class="w-10 h-10 bg-slate-100 rounded-xl flex items-center justify-center text-slate-500">
                                         <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
                                    </div>
                                    <div class="flex-1 min-w-0 text-left">
                                        <p class="text-sm font-bold text-slate-800 truncate">${message.attach.filename}</p>
                                        <p class="text-[10px] font-medium text-slate-500">${(message.attach.size / 1024).toFixed(1)} KB</p>
                                    </div>
                                </a>
                            </div>`;
                        }
                    }

                html = `
                <div class="flex items-end gap-3 group animate-in slide-in-from-left-5 fade-in duration-300 mb-4">
                    <img src="${img}" class="w-8 h-8 rounded-full object-cover shadow-sm ring-2 ring-white self-end mb-6">
                    <div class="flex flex-col space-y-1 max-w-lg">
                        ${attachmentHtml}
                        ${message.text ? `<div class="bg-white px-5 py-3.5 rounded-[1.3rem] rounded-bl-none shadow-sm text-slate-800 text-[15px] leading-relaxed border border-slate-100/50">${message.text}</div>` : ''}
                        <span class="text-[10px] font-bold text-slate-400 pl-2">Maintenant</span>
                    </div>
                </div>
                `;
                }

                messagesBox.insertAdjacentHTML('beforeend', html);

                messagesBox.scrollTop = messagesBox.scrollHeight;
            }
            if (form) {

                form.addEventListener('submit', function (e) {

                    e.preventDefault();

                    let textarea = form.querySelector('textarea');
                    let text = textarea.value;
                    let fileInput = document.getElementById('attachment');
                    let hasFile = fileInput.files.length > 0;

                    if (text.trim() == "" && !hasFile) return;

                    let data = new FormData(form);

                    fetch(form.action, {
                        method: "POST",
                        body: data,
                        headers: {
                            "X-CSRF-TOKEN": document
                                .querySelector('meta[name="csrf-token"]').content,
                            "Accept": "application/json"
                        }
                    })
                        .then(res => res.json())
                        .then(res => {

                            if (res.success) {
                                textarea.value = "";
                                fileInput.value = "";
                                document.getElementById('file-preview-container').classList.add('hidden');
                                addMessage(res.message);
                            }

=======

            function isVue(conversationId) {
                fetch(`/conversations/${conversationId}/isVue`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                });
            }

        if (conversationId) {
            isVue(conversationId);
        }

            function addMessage(message) {

            if (!messagesBox) return;

            let isMe = message.sender_id == userId;

                let myImage = "{{ auth()->user()->image ?? 'https://ui-avatars.com/api/?name=' . urlencode(auth()->user()->nom) . '&color=7F9CF5&background=EBF4FF' }}";
                let otherImage = "{{ isset($selected_user) ? ($selected_user->image ?? 'https://ui-avatars.com/api/?name=' . urlencode($selected_user->nom) . '&color=7F9CF5&background=EBF4FF') : '' }}";

                let img = isMe ? myImage : otherImage;

            let html = "";

                if (isMe) {
                    let attachmentHtml = '';
                    if (message.attach && message.attach.path) {
                        let path = "/storage/" + message.attach.path;
                        if (message.attach.mime_type.startsWith('image/')) {
                            attachmentHtml = `
                            <div class="mb-1">
                                <a href="${path}" target="_blank" class="block overflow-hidden rounded-2xl border-4 border-white shadow-md transition-transform hover:scale-[1.02]">
                                    <img src="${path}" class="max-w-[240px] max-h-[240px] object-cover">
                                </a>
                            </div>`;
                        } else {
                            attachmentHtml = `
                            <div class="mb-1">
                                <a href="${path}" target="_blank" class="flex items-center gap-3 bg-white p-3 rounded-2xl border border-indigo-100 shadow-sm hover:shadow-md transition-all max-w-[240px]">
                                    <div class="w-10 h-10 bg-indigo-50 rounded-xl flex items-center justify-center text-indigo-500">
                                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
                                    </div>
                                    <div class="flex-1 min-w-0 text-left">
                                        <p class="text-sm font-bold text-slate-800 truncate">${message.attach.filename}</p>
                                        <p class="text-[10px] font-medium text-slate-500">${(message.attach.size / 1024).toFixed(1)} KB</p>
                                    </div>
                                </a>
                            </div>`;
                        }
                    }

                html = `
                <div class="flex items-end justify-end gap-3 group animate-in slide-in-from-right-5 fade-in duration-300">
                    <div class="flex flex-col space-y-1 max-w-lg items-end">
                        ${attachmentHtml}
                        ${message.text ? `<div class="relative bg-gradient-to-br from-indigo-600 to-violet-600 px-5 py-3.5 rounded-[1.3rem] rounded-br-none shadow-lg shadow-indigo-500/20 text-white text-[15px] leading-relaxed">${message.text}</div>` : ''}
                        <div class="flex items-center gap-1.5 pr-1 opacity-60">
                            <span class="text-[10px] font-bold text-slate-400">Maintenant</span>
                             <svg class="w-3.5 h-3.5 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                        </div>
                    </div>
                    <img src="${img}" class="w-8 h-8 rounded-full object-cover shadow-sm ring-2 ring-white self-end mb-6">
                </div>
                `;

                } else {
                    let attachmentHtml = '';
                    if (message.attach && message.attach.path) {
                        let path = "/storage/" + message.attach.path;
                        if (message.attach.mime_type && message.attach.mime_type.startsWith('image/')) {
                            attachmentHtml = `
                            <div class="mb-1">
                                <a href="${path}" target="_blank" class="block overflow-hidden rounded-2xl border-4 border-white shadow-md transition-transform hover:scale-[1.02]">
                                    <img src="${path}" class="max-w-[240px] max-h-[240px] object-cover">
                                </a>
                            </div>`;
                        } else {
                            attachmentHtml = `
                            <div class="mb-1">
                                <a href="${path}" target="_blank" class="flex items-center gap-3 bg-white p-3 rounded-2xl border border-slate-100 shadow-sm hover:shadow-md transition-all max-w-[240px]">
                                    <div class="w-10 h-10 bg-slate-100 rounded-xl flex items-center justify-center text-slate-500">
                                         <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
                                    </div>
                                    <div class="flex-1 min-w-0 text-left">
                                        <p class="text-sm font-bold text-slate-800 truncate">${message.attach.filename}</p>
                                        <p class="text-[10px] font-medium text-slate-500">${(message.attach.size / 1024).toFixed(1)} KB</p>
                                    </div>
                                </a>
                            </div>`;
                        }
                    }

                html = `
                <div class="flex items-end gap-3 group animate-in slide-in-from-left-5 fade-in duration-300">
                    <img src="${img}" class="w-8 h-8 rounded-full object-cover shadow-sm ring-2 ring-white self-end mb-6">
                    <div class="flex flex-col space-y-1 max-w-lg">
                        ${attachmentHtml}
                        ${message.text ? `<div class="bg-white px-5 py-3.5 rounded-[1.3rem] rounded-bl-none shadow-sm text-slate-800 text-[15px] leading-relaxed border border-slate-100/50">${message.text}</div>` : ''}
                        <span class="text-[10px] font-bold text-slate-400 pl-2">Maintenant</span>
                    </div>
                </div>
                `;
                }

            messagesBox.insertAdjacentHTML('beforeend', html);

                messagesBox.scrollTop = messagesBox.scrollHeight;
            }
            if (form) {

                form.addEventListener('submit', function (e) {

                    e.preventDefault();

                    let textarea = form.querySelector('textarea');
                    let text = textarea.value;
                    let fileInput = document.getElementById('attachment');
                    let hasFile = fileInput.files.length > 0;

                    if (text.trim() == "" && !hasFile) return;

                    let data = new FormData(form);

                    fetch(form.action, {
                        method: "POST",
                        body: data,
                        headers: {
                            "X-CSRF-TOKEN": document
                                .querySelector('meta[name="csrf-token"]').content,
                            "Accept": "application/json"
                        }
                    })
                        .then(res => res.json())
                        .then(res => {

                            }
                        })
                        .catch(err => console.log(err));

                });
            }

            function initMessaging() {
                if (!window.Echo) {
                    setTimeout(initMessaging, 500);
                    return;
                }
                
                @foreach($conversations as $conv)
                    window.Echo.private("conversation.{{ $conv->id }}")
                        .listen(".message.sent", function (e) {

                            if (e.message.sender_id != userId) {
                                if (conversationId && conversationId == {{ $conv->id }} ) {
                                    addMessage(e.message);
                                    isVue(conversationId);
                                }
                                else {
                                    // Robust selection using data-con-id
                                    let convItem = document.querySelector(`a[data-con-id="{{ $conv->id }}"]`);
                                    
                                    if (convItem) {

                                        
                                        // 1. Update Preview Text
                                        let previewText = e.message.text ? 
                                            (e.message.text.length > 25 ? e.message.text.substring(0, 25) + '..' : e.message.text) : 
                                            '<span class="flex items-center gap-1 italic"><svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13" /></svg> Fichier</span>';
                                            
                                        let previewParagraph = convItem.querySelector('[data-ui="message-preview"]');
                                        if (previewParagraph) {
                                            previewParagraph.innerHTML = previewText;
                                            previewParagraph.classList.add('text-slate-900', 'font-bold'); // Mark as unread visually
                                            previewParagraph.classList.remove('text-slate-500');
                                        }

                                        // 2. Update Time
                                        let time = new Date(e.message.created_at).toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
                                        let timeSpan = convItem.querySelector('[data-ui="time-display"]');
                                        
                                        if (timeSpan) {
                                            timeSpan.textContent = time;
                                        }

                                        // 3. Update Unread Badge
                                        let avatarContainer = convItem.querySelector('[data-ui="avatar-container"]');
                                        if (avatarContainer) {
                                            let existingBadge = avatarContainer.querySelector('[data-ui="unread-badge"]');
                                            
                                            if (existingBadge) {
                                                let countSpan = existingBadge.querySelector('[data-ui="unread-count"]');
                                                if (countSpan) {
                                                    let count = parseInt(countSpan.textContent) || 0;
                                                    countSpan.textContent = count + 1;
                                                }
                                            } else {
                                                // Create new badge
                                                avatarContainer.insertAdjacentHTML('beforeend', `
                                                    <div class="absolute -top-2 -left-2" data-ui="unread-badge">
                                                        <span class="flex h-5 w-5 relative">
                                                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-rose-400 opacity-75"></span>
                                                            <span class="relative inline-flex rounded-full h-5 w-5 bg-gradient-to-r from-rose-500 to-pink-600 text-white text-[10px] font-black items-center justify-center border-2 border-white shadow-sm" data-ui="unread-count">1</span>
                                                        </span>
                                                    </div>
                                                `);
                                            }
                                        }
                                    }
                                }
                            }
                        });

                    window.Echo.private("conversation.{{ $conv->id }}")
                        .listen(".user.typing", function (e) {
                             if (e.user.id != userId && conversationId == {{ $conv->id }}) {
                                showTypingIndicator();
                             }
                        });
                @endforeach
                
                // Presence Channel for Online Status
                window.Echo.join('online')
                    .here((users) => {
                        users.forEach(user => updateUserStatus(user.id, true));
                    })
                    .joining((user) => {
                        updateUserStatus(user.id, true);
                    })
                    .leaving((user) => {
                        updateUserStatus(user.id, false);
                    });
        }

        function updateUserStatus(userId, isOnline) {
            const statusDots = document.querySelectorAll(`[data-user-status="${userId}"]`);
            statusDots.forEach(dot => {
                if (isOnline) {
                    dot.classList.remove('bg-slate-300');
                    dot.classList.add('bg-emerald-500');
                } else {
                    dot.classList.remove('bg-emerald-500');
                    dot.classList.add('bg-slate-300');
                }
            });
        }

            initMessaging();

            const attachmentInput = document.getElementById('attachment');
            const previewContainer = document.getElementById('file-preview-container');
            const imagePreview = document.getElementById('image-preview');
            const fileIcon = document.getElementById('file-icon');
            const fileName = document.getElementById('file-name');
            const fileSize = document.getElementById('file-size');
            const removeFileBtn = document.getElementById('remove-file');

            if (attachmentInput) {
                attachmentInput.addEventListener('change', function () {
                    const file = this.files[0];
                    if (file) {

                        previewContainer.classList.remove('hidden');
                        fileName.textContent = file.name;
                        fileSize.textContent = formatBytes(file.size);

                        if (file.type.startsWith('image/')) {
                            const reader = new FileReader();
                            reader.onload = function (e) {
                                imagePreview.src = e.target.result;
                                imagePreview.classList.remove('hidden');
                                fileIcon.classList.add('hidden');
                            }
                            reader.readAsDataURL(file);
                        } else {
                            imagePreview.classList.add('hidden');
                            fileIcon.classList.remove('hidden');
                        }
                    }
                });

                removeFileBtn.addEventListener('click', function () {
                    attachmentInput.value = '';
                    previewContainer.classList.add('hidden');
                });
            }

            function formatBytes(bytes, decimals = 2) {
                if (bytes === 0) return '0 Bytes';
                const k = 1024;
                const dm = decimals < 0 ? 0 : decimals;
                const sizes = ['Bytes', 'KB', 'MB', 'GB', 'TB'];
                const i = Math.floor(Math.log(bytes) / Math.log(k));
            return parseFloat((bytes / Math.pow(k, i)).toFixed(dm)) + ' ' + sizes[i];
            }

            // Typing Indicator Logic
            let typingTimer;
            const typingIndicator = document.getElementById('typing-indicator');
            const onlineStatus = document.getElementById('online-status');
            
            function showTypingIndicator() {
                if(typingIndicator && onlineStatus) {
                    typingIndicator.classList.remove('hidden');
                    onlineStatus.classList.add('hidden');
                    
                    clearTimeout(typingTimer);
                    typingTimer = setTimeout(() => {
                        typingIndicator.classList.add('hidden');
                        onlineStatus.classList.remove('hidden');
                    }, 3000);
                }
            }

            // Trigger typing event
            const messageInput = document.getElementById('message-input');
            let isTyping = false;
            let lastTypingTime = 0;

            if (messageInput && conversationId) {
                messageInput.addEventListener('keydown', function() {
                    const now = Date.now();
                    if (!isTyping || now - lastTypingTime > 2000) {
                        isTyping = true;
                        lastTypingTime = now;
                        
                        fetch(`/conversations/${conversationId}/typing`, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                            },
                        });

                        setTimeout(() => isTyping = false, 2000);
                    }
                });
            }

        });

    function toggleDropdown(id) {
        const dropdown = document.getElementById(`dropdown-${id}`);
        const allDropdowns = document.querySelectorAll('[id^="dropdown-"]');
        
        allDropdowns.forEach(d => {
            if (d.id !== `dropdown-${id}`) {
                d.classList.add('hidden');
            }
        });

        if (dropdown) {
            dropdown.classList.toggle('hidden');
        }
    }

    window.onclick = function(event) {
        if (!event.target.closest('.group')) {
             const allDropdowns = document.querySelectorAll('[id^="dropdown-"]');
             allDropdowns.forEach(d => d.classList.add('hidden'));
        }
    }
