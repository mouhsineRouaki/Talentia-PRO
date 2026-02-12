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
        <x-flash-message />
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
                class="bg-white border-t-4 border-indigo-600 shadow-2xl p-4 rounded-xl flex items-center space-x-4 min-w-[320px] max-w-sm pointer-events-auto cursor-pointer hover:bg-gray-50 transition-all border border-gray-100">
                <div class="relative flex-shrink-0">
                    <img :src="toast.image" class="w-12 h-12 rounded-full object-cover shadow-sm ring-2 ring-indigo-50">
                    <span
                        class="absolute bottom-0 right-0 block h-3 w-3 rounded-full bg-green-500 ring-2 ring-white"></span>
                </div>
                <div class="flex-1 min-w-0">
                    <div class="flex justify-between items-start">
                        <p class="text-sm font-bold text-gray-900 truncate" x-text="toast.sender"></p>
                        <span
                            class="text-[10px] text-indigo-500 font-semibold bg-indigo-50 px-2 py-0.5 rounded-full">Nouveau</span>
                    </div>
                    <p class="text-xs text-gray-600 truncate mt-0.5" x-text="toast.message"></p>
                </div>
                <button @click.stop="hideToast(toast.id)"
                    class="bg-gray-50 hover:bg-gray-100 p-1.5 rounded-full text-gray-400 hover:text-gray-600 transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
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
                    let userId = {{ auth()->id() }};
                    if (userId) {
                        window.addEventListener('load', () => {
                            if (window.Echo) {
                                window.Echo.private(`user.${userId}`)
                                    .listen('.message.sent', (e) => {
                                        // Skip if we're on the chat page with this conversation
                                        if (window.location.pathname.includes(`/chat/${e.message.conversation_id}`)) {
                                            return;
                                        }
                                        this.addToast({
                                            conversation_id: e.message.conversation_id,
                                            sender: e.message.sender_name,
                                            message: e.message.text || '📎 Pièce jointe',
                                            image: e.message.sender_image,
                                            url: `/chat/${e.message.conversation_id}`
                                        });
                                    })
                                    .listen('.notification.created', (e) => {
                                        this.addToast({
                                            sender: 'TalentBridge',
                                            message: e.notification.contenu,
                                            image: null,
                                            url: e.notification.type === 'offer' ? '/offers' : '/friends'
                                        });
                                    });
                            }
                        });
                    }
                },
                addToast(data) {
                    let id = Date.now();
                    let toast = {
                        id: id,
                        sender: data.sender,
                        message: data.message,
                        url: data.url,
                        image: data.image || `https://ui-avatars.com/api/?name=${encodeURIComponent(data.sender)}&color=7F9CF5&background=EBF4FF`,
                        visible: true
                    };
                    this.toasts.push(toast);
                    setTimeout(() => this.hideToast(id), 3000);
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