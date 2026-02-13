<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'TalentBridge') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />
    <script src="https://cdn.tailwindcss.com"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>

<body class="font-sans antialiased bg-[#f4f2ee] text-slate-900">
    <div class="min-h-screen">
        <x-navigation :active="$active ?? 'dashboard' " />

        @if (isset($header))
            <header class="py-5">
                <div class="sm:px-6 lg:px-8">
                    <div class="rounded-2xl bg-white/80 backdrop-blur border border-slate-200/70 px-5 py-4 shadow-sm">
                        {{ $header }}
                    </div>
                </div>
            </header>
        @endif

        <main class="pb-10">
            <div class=" sm:px-6 lg:px-8">
                @if (session()->has('success'))
                    <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                        <span class="block sm:inline">{{ session('success') }}</span>
                    </div>
                @endif
                @if (session()->has('error'))
                    <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                        <span class="block sm:inline">{{ session('error') }}</span>
                    </div>
                @endif
                {{ $slot }}
            </div>
        </main>

        <footer class="py-10">
            <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 text-center text-xs text-slate-500">
                © {{ date('Y') }} TalentBridge • Connecter recruteurs & chercheurs
            </div>
        </footer>
    </div>
    @livewireScripts

    <!-- Real-time Flash Notifications -->
    <div x-data="toastHandler()"
        class="fixed top-5 left-1/2 -translate-x-1/2 z-[100] flex flex-col space-y-2 pointer-events-none">
        <template x-for="toast in toasts" :key="toast.id">
            <div x-show="toast.visible" x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="-translate-y-full opacity-0"
                x-transition:enter-end="translate-y-0 opacity-100" x-transition:leave="transition ease-in duration-200"
                x-transition:leave-start="translate-y-0 opacity-100"
                x-transition:leave-end="-translate-y-full opacity-0" @click="window.location.href = toast.url"
                class="bg-white/95 backdrop-blur-md border-t-4 border-emerald-500 shadow-[0_10px_40px_-10px_rgba(0,0,0,0.1)] p-4 rounded-2xl flex items-center space-x-4 min-w-[320px] max-w-sm pointer-events-auto cursor-pointer hover:bg-white transition-all border border-slate-100 group">
                <div class="relative flex-shrink-0">
                    <img :src="toast.image"
                        class="w-12 h-12 rounded-full object-cover shadow-sm ring-4 ring-slate-50 group-hover:ring-emerald-50 transition-all">
                    <div
                        class="absolute -bottom-1 -right-1 h-5 w-5 bg-emerald-500 rounded-full border-2 border-white flex items-center justify-center shadow-sm">
                        <svg class="w-2.5 h-2.5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3"
                                d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9">
                            </path>
                        </svg>
                    </div>
                </div>
                <div class="flex-1 min-w-0">
                    <div class="flex justify-between items-start">
                        <p class="text-sm font-bold text-slate-800 truncate" x-text="toast.sender"></p>
                        <span
                            class="text-[10px] text-emerald-600 font-bold bg-emerald-50 px-2 py-0.5 rounded-full uppercase tracking-wider">Nouveau</span>
                    </div>
                    <p class="text-xs text-slate-600 line-clamp-2 mt-0.5 leading-relaxed" x-text="toast.message"></p>
                </div>
                <button @click.stop="hideToast(toast.id)"
                    class="bg-slate-50 group-hover:bg-slate-100 p-2 rounded-xl text-slate-400 hover:text-slate-600 transition-all">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                            d="M6 18L18 6M6 6l12 12">
                        </path>
                    </svg>
                </button>
            </div>
        </template>
    </div>

    <script>
        function toastHandler() {
            return {
                toasts: [],
                init() {
                    let userId = {{ auth()->id() ?? 'null' }};
                    if (userId) {
                        const setupEcho = () => {
                            if (window.Echo) {
                                window.Echo.private(`user.${userId}`)
                                    .listen('.notification.created', (e) => {
                                        console.log('Notification received:', e);
                                        // If it's a message notification, we might already have a more detailed toast from .message.sent
                                        // But for now, let's just make sure it shows if it's not a message, or handle it simply.
                                        if (e.notification.contenu.includes('message')) {
                                             // If we are on the chat page, don't show toast for messages
                                             if (window.location.pathname.includes('/conversations/')) return;
                                        }

                                        this.addToast({
                                            sender: 'TalentBridge',
                                            message: e.notification.contenu,
                                            image: null,
                                            url: e.notification.type === 'offer' ? '/offers' : 
                                                 (e.notification.type === 'friend_request' ? '/friends' : 
                                                 (e.notification.contenu.includes('message') ? '/conversations' : '/notifications'))
                                        });
                                    })
                                    .listen('.message.sent', (e) => {
                                        console.log('Message received:', e);
                                        if (window.location.pathname.includes(`/conversations/${e.message.conversation_id}`)) {
                                            return;
                                        }
                                        this.addToast({
                                            id: 'msg-' + e.message.id, // Fixed ID to prevent duplicates if both events fire
                                            sender: e.message.sender_name,
                                            message: e.message.text || '📎 Pièce jointe',
                                            image: e.message.sender_image,
                                            url: `/conversations/${e.message.conversation_id}`
                                        });
                                    });
                                return true;
                            }
                            return false;
                        };

                        if (!setupEcho()) {
                            const interval = setInterval(() => {
                                if (setupEcho()) clearInterval(interval);
                            }, 500);
                        }
                    }
                },
                addToast(data) {
                    let id = data.id || Date.now();
                    
                    // Prevent duplicates
                    if (this.toasts.some(t => t.id === id)) return;

                    let toast = {
                        id: id,
                        sender: data.sender,
                        message: data.message,
                        url: data.url,
                        image: data.image || `https://ui-avatars.com/api/?name=${encodeURIComponent(data.sender)}&color=059669&background=ECFDF5`,
                        visible: true
                    };
                    this.toasts.push(toast);
                    setTimeout(() => this.hideToast(id), 5000);
                },
                hideToast(id) {
                    let index = this.toasts.findIndex(t => t.id === id);
                    if (index !== -1) {
                        this.toasts[index].visible = false;
                        setTimeout(() => {
                            this.toasts = this.toasts.filter(t => t.id !== id);
                        }, 500);
                    }
                }
            }
        }
    </script>
</body>

</html>