<x-app-layout>
    <div class="h-[calc(100vh-65px)] overflow-hidden bg-gray-100 flex">
        <!-- Sidebar -->
        <div class="w-1/3 bg-white border-r border-gray-200 flex flex-col">
            <!-- Header & Search -->
            <div class="p-4 border-b border-gray-100">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-2xl font-bold text-gray-800">Messages</h2>
                    <button class="p-2 rounded-full hover:bg-gray-100 text-gray-500 transition">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                        </svg>
                    </button>
                </div>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                        <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </span>
                    <input type="text" placeholder="Rechercher..." class="w-full py-2 pl-10 pr-4 bg-gray-50 border-none rounded-2xl text-sm focus:ring-2 focus:ring-indigo-500 focus:bg-white transition-all placeholder-gray-400 text-gray-700">
                </div>
            </div>

            <!-- Conversation List -->
            <div class="flex-1 overflow-y-auto custom-scrollbar">
                <!-- Active Conversation -->
                 @foreach ($amis_user as $amis)
                    <div class="group relative px-4 py-3 cursor-pointer bg-indigo-50 border-l-4 border-indigo-600 transition-all hover:bg-indigo-100">
                        <div class="flex items-start space-x-3">
                            <div class="relative">
                                <img src="{{ $amis->image }}" alt="Sarah" class="w-12 h-12 rounded-full object-cover ring-2 ring-white">
                                <span class="absolute bottom-0 right-0 w-3 h-3 bg-green-500 border-2 border-white rounded-full"></span>
                            </div>
                            <div class="flex-1 min-w-0">
                                <div class="flex justify-between items-baseline mb-1">
                                    <h3 class="text-sm font-bold text-gray-900 truncate">{{ $amis->nom }} {{  $amis->prenom }}</h3>
                                    <span class="text-xs font-medium text-indigo-600"></span>
                                </div>
                                <p class="text-sm text-gray-700 font-medium truncate"></p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Chat Area -->
        <div class="flex-1 flex flex-col bg-white">
            <!-- Chat Header -->
            <div class="px-6 py-3 border-b border-gray-200 bg-white shadow-sm z-10 flex items-center justify-between">
                <div class="flex items-center space-x-4">
                     <div class="relative">
                        <img src="https://i.pravatar.cc/150?img=11" alt="Sarah" class="w-10 h-10 rounded-full object-cover shadow-sm">
                        <span class="absolute bottom-0 right-0 w-2.5 h-2.5 bg-green-500 border-2 border-white rounded-full"></span>
                     </div>
                    <div>
                        <h3 class="text-lg font-bold text-gray-900">Sarah Connor</h3>
                        <div class="flex items-center space-x-1">
                            <span class="w-2 h-2 rounded-full bg-green-500 animate-pulse"></span>
                            <p class="text-xs text-green-600 font-medium">En ligne</p>
                        </div>
                    </div>
                </div>
                <div class="flex items-center space-x-3">
                     <button class="p-2 text-gray-400 hover:text-indigo-600 hover:bg-indigo-50 rounded-full transition">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
</svg>
                    </button>
                    <button class="p-2 text-gray-400 hover:text-indigo-600 hover:bg-indigo-50 rounded-full transition">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.82v6.36a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z" />
</svg>
                    </button>
                    <div class="w-px h-6 bg-gray-200 mx-2"></div>
                    <button class="p-2 text-gray-400 hover:text-gray-600 hover:bg-gray-100 rounded-full transition">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z" />
</svg>
                    </button>
                </div>
            </div>

            <!-- Messages Stream -->
            <div class="flex-1 overflow-y-auto p-6 space-y-6 bg-slate-50 relative">
                <!-- Date Separator -->
                <div class="flex justify-center">
                    <span class="px-4 py-1 text-xs font-semibold text-gray-500 bg-gray-200 rounded-full shadow-sm">Aujourd'hui</span>
                </div>

                <!-- Received Message Group -->
                <div class="flex items-end space-x-2">
                    <img src="https://i.pravatar.cc/150?img=11" alt="Sarah" class="w-8 h-8 rounded-full object-cover shadow-sm mb-1">
                    <div class="flex flex-col space-y-1 max-w-lg">
                        <div class="bg-white px-4 py-3 rounded-2xl rounded-bl-none shadow-sm text-gray-800 text-sm leading-relaxed border border-gray-100">
                             Bonjour ! Je suis intéressée par l'offre de développeur React.
                        </div>
                        <span class="text-xs text-gray-400 pl-2">10:00</span>
                    </div>
                </div>

                <!-- Sent Message Group -->
                <div class="flex items-end justify-end space-x-2">
                    <div class="flex flex-col space-y-1 max-w-lg items-end">
                        <div class="bg-indigo-600 px-4 py-3 rounded-2xl rounded-br-none shadow-md text-white text-sm leading-relaxed">
                            Bonjour Sarah, ravie de l'entendre ! Avez-vous de l'expérience avec Next.js ?
                        </div>
                         <div class="flex items-center space-x-1 pr-1">
                             <span class="text-xs text-gray-400">10:05</span>
                             <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 text-indigo-400" viewBox="0 0 20 20" fill="currentColor">
  <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
</svg>
                        </div>
                    </div>
                     <img src="{{ auth()->user()->image ?? 'https://i.pravatar.cc/150?img=3' }}" alt="Me" class="w-8 h-8 rounded-full object-cover shadow-sm mb-1">
                </div>

                 <!-- Received Message Group -->
                 <div class="flex items-end space-x-2">
                    <img src="https://i.pravatar.cc/150?img=11" alt="Sarah" class="w-8 h-8 rounded-full object-cover shadow-sm mb-1">
                    <div class="flex flex-col space-y-1 max-w-lg">
                        <div class="bg-white px-4 py-3 rounded-2xl rounded-bl-none shadow-sm text-gray-800 text-sm leading-relaxed border border-gray-100">
                            Oui, j'ai travaillé sur 3 projets Next.js l'année dernière. Je peux vous envoyer mon portfolio si vous voulez.
                        </div>
                         <span class="text-xs text-gray-400 pl-2">10:15</span>
                    </div>
                </div>

                <!-- Sent Message Group -->
                <div class="flex items-end justify-end space-x-2">
                    <div class="flex flex-col space-y-1 max-w-lg items-end">
                        <div class="bg-indigo-600 px-4 py-3 rounded-2xl rounded-br-none shadow-md text-white text-sm leading-relaxed">
                            Ce serait parfait. Merci !
                        </div>
                         <div class="flex items-center space-x-1 pr-1">
                             <span class="text-xs text-gray-400">10:20</span>
                             <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 text-indigo-400" viewBox="0 0 20 20" fill="currentColor">
  <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
</svg>
                        </div>
                    </div>
                     <img src="{{ auth()->user()->image ?? 'https://i.pravatar.cc/150?img=3' }}" alt="Me" class="w-8 h-8 rounded-full object-cover shadow-sm mb-1">
                </div>

                  <!-- Received Message Group -->
                  <div class="flex items-end space-x-2">
                    <img src="https://i.pravatar.cc/150?img=11" alt="Sarah" class="w-8 h-8 rounded-full object-cover shadow-sm mb-1">
                    <div class="flex flex-col space-y-1 max-w-lg">
                        <div class="bg-white px-4 py-3 rounded-2xl rounded-bl-none shadow-sm text-gray-800 text-sm leading-relaxed border border-gray-100">
                           Merci pour votre proposition, je suis disponible pour un entretien quand vous le souhaitez.
                        </div>
                         <span class="text-xs text-gray-400 pl-2">10:30</span>
                    </div>
                </div>
            </div>

            <!-- Input Area -->
            <div class="p-4 bg-white border-t border-gray-200">
                <div class="flex items-end space-x-4 bg-gray-50 p-2 rounded-3xl border border-gray-200 focus-within:ring-2 focus-within:ring-indigo-100 focus-within:border-indigo-300 transition-all shadow-sm">
                    <button class="p-2 text-gray-400 hover:text-indigo-600 transition self-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13" />
</svg>
                    </button>
                    <textarea 
                        placeholder="Écrivez votre message..." 
                        class="w-full bg-transparent border-none focus:ring-0 resize-none py-3 text-gray-700 placeholder-gray-400 max-h-32"
                        rows="1"
                    ></textarea>
                    <div class="flex items-center space-x-2 self-center pb-2">
                         <button class="p-2 text-gray-400 hover:text-yellow-500 transition">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
</svg>
                        </button>
                        <button class="bg-indigo-600 text-white rounded-full p-3 shadow-lg hover:bg-indigo-700 hover:shadow-xl transition transform hover:-translate-y-0.5">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
  <path d="M10.894 2.553a1 1 0 00-1.788 0l-7 14a1 1 0 001.169 1.409l5-1.429A1 1 0 009 15.571V11a1 1 0 112 0v4.571a1 1 0 00.725.962l5 1.428a1 1 0 001.17-1.408l-7-14z" />
</svg>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
