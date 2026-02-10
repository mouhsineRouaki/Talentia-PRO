<x-app-layout>
    <div class="h-[calc(100vh-65px)] overflow-hidden bg-gray-100 flex" data-user-id="{{ auth()->id() }}">
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

            <div class="flex-1 overflow-y-auto custom-scrollbar">
                 @forelse ($conversations as $conv)
                    @php
                        $friend = ($conv->user_one_id == auth()->id()) ? $conv->userTow : $conv->userOne;
                        $isSelected = isset($conversation) && $conversation->id === $conv->id;
                    @endphp
                    <a href="{{ route('chat.show', $conv->id) }}" class="block group relative px-4 py-3 cursor-pointer transition-all {{ $isSelected ? 'bg-indigo-50 border-l-4 border-indigo-600' : 'bg-white hover:bg-gray-50 border-l-4 border-transparent' }}">
                        <div class="flex items-start space-x-3">
                            <div class="relative">
                                <img src="{{ $friend->image ?? 'https://i.pravatar.cc/150?u='.$friend->id }}" alt="{{ $friend->nom }}" class="w-12 h-12 rounded-full object-cover ring-2 {{ $isSelected ? 'ring-indigo-200' : 'ring-gray-100' }}">
                            </div>
                            <div class="flex-1 min-w-0">
                                <div class="flex justify-between items-baseline mb-1">
                                    <h3 class="text-sm font-bold {{ $isSelected ? 'text-indigo-900' : 'text-gray-900' }} truncate">
                                        {{ $friend->nom }} {{  $friend->prenom }}
                                    </h3>
                                </div>
                                <p class="text-sm {{ $isSelected ? 'text-indigo-600' : 'text-gray-500' }} font-medium truncate">
                                    Cliquez pour discuter
                                </p>
                            </div>
                        </div>
                    </a>
                @empty
                    <div class="p-6 text-center text-gray-500">
                        <p class="text-sm">Aucune conversation.</p>
                        <a href="{{ route('friends.index') }}" class="mt-2 inline-block text-xs font-medium text-indigo-600 hover:text-indigo-500">
                            Commencer une discussion
                        </a>
                    </div>
                @endforelse
            </div>  
        </div>

        <div class="flex-1 flex flex-col bg-white">
                @if($selected_user)
                <div class="px-6 py-3 border-b border-gray-200 bg-white shadow-sm z-10 flex items-center justify-between">
                    <div class="flex items-center space-x-4">
                         <div class="relative">
                            <img src="{{$selected_user->image }}" alt="{{ $selected_user->prenom  }}" class="w-10 h-10 rounded-full object-cover shadow-sm">
                            <span class="absolute bottom-0 right-0 w-2.5 h-2.5 bg-green-500 border-2 border-white rounded-full"></span>
                         </div>
                        <div>
                            <h3 class="text-lg font-bold text-gray-900">
                                {{  $selected_user->prenom . ' ' . $selected_user->nom  }}
                            </h3>
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

                <div class="flex-1 overflow-y-auto p-6 space-y-6 bg-slate-50 relative">
                    <div class="flex justify-center">
                        <span class="px-4 py-1 text-xs font-semibold text-gray-500 bg-gray-200 rounded-full shadow-sm">Aujourd'hui</span>
                    </div>

                    @if(isset($messages))
                        @foreach($messages as $message)
                            @if($message->sender_id == auth()->id())
                                <div class="flex items-end justify-end space-x-2">
                                    <div class="flex flex-col space-y-1 max-w-lg items-end">
                                        @if(isset($message->attach) && !empty($message->attach['path']))
                                            <div class="mb-1">
                                                @if(Str::startsWith($message->attach['mime_type'], 'image/'))
                                                    <a href="{{ asset('storage/' . $message->attach['path']) }}" target="_blank">
                                                        <img src="{{ asset('storage/' . $message->attach['path']) }}" class="max-w-[200px] max-h-[200px] rounded-lg shadow-sm border border-indigo-200 object-cover cursor-pointer hover:opacity-90 transition">
                                                    </a>
                                                @else
                                                    <a href="{{ asset('storage/' . $message->attach['path']) }}" target="_blank" class="flex items-center space-x-2 bg-indigo-50 p-2 rounded-lg border border-indigo-100 hover:bg-indigo-100 transition shadow-sm max-w-[200px]">
                                                        <div class="bg-indigo-100 p-2 rounded-lg text-indigo-500">
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                                            </svg>
                                                        </div>
                                                        <div class="flex-1 min-w-0">
                                                            <p class="text-xs font-medium text-indigo-900 truncate">{{ $message->attach['filename'] }}</p>
                                                            <p class="text-[10px] text-indigo-500">{{ number_format($message->attach['size'] / 1024, 1) }} KB</p>
                                                        </div>
                                                    </a>
                                                @endif
                                            </div>
                                        @endif
                                        @if($message->text)
                                            <div class="bg-indigo-600 px-4 py-3 rounded-2xl rounded-br-none shadow-md text-white text-sm leading-relaxed">
                                                {{ $message->text }}
                                            </div>
                                        @endif
                                        <div class="flex items-center space-x-1 pr-1 justify-end">
                                            <span class="text-xs text-gray-400">{{ $message->created_at->format('H:i') }}</span>
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 text-indigo-400" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                            </svg>
                                        </div>
                                    </div>
                                    <img src="{{ auth()->user()->image ?? 'https://i.pravatar.cc/150?u='.auth()->id() }}" alt="Me" class="w-8 h-8 rounded-full object-cover shadow-sm mb-1">
                                </div>
                            @else
                                <div class="flex items-end space-x-2">
                                    <img src="{{ $selected_user->image ?? 'https://i.pravatar.cc/150?u='.$selected_user->id }}" alt="{{ $selected_user->nom }}" class="w-8 h-8 rounded-full object-cover shadow-sm mb-1">
                                    <div class="flex flex-col space-y-1 max-w-lg">
                                        @if(isset($message->attach) && !empty($message->attach['path']))
                                            <div class="mb-1">
                                                @if(Str::startsWith($message->attach['mime_type'], 'image/'))
                                                    <a href="{{ asset('storage/' . $message->attach['path']) }}" target="_blank">
                                                        <img src="{{ asset('storage/' . $message->attach['path']) }}" class="max-w-[200px] max-h-[200px] rounded-lg shadow-sm border border-gray-100 object-cover cursor-pointer hover:opacity-90 transition">
                                                    </a>
                                                @else
                                                    <a href="{{ asset('storage/' . $message->attach['path']) }}" target="_blank" class="flex items-center space-x-2 bg-gray-50 p-2 rounded-lg border border-gray-100 hover:bg-gray-100 transition shadow-sm max-w-[200px]">
                                                        <div class="bg-gray-200 p-2 rounded-lg text-gray-500">
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                                            </svg>
                                                        </div>
                                                        <div class="flex-1 min-w-0">
                                                            <p class="text-xs font-medium text-gray-700 truncate">{{ $message->attach['filename'] }}</p>
                                                            <p class="text-[10px] text-gray-400">{{ number_format($message->attach['size'] / 1024, 1) }} KB</p>
                                                        </div>
                                                    </a>
                                                @endif
                                            </div>
                                        @endif
                                        @if($message->text)
                                            <div class="bg-white px-4 py-3 rounded-2xl rounded-bl-none shadow-sm text-gray-800 text-sm leading-relaxed border border-gray-100">
                                                {{ $message->text }}
                                            </div>
                                        @endif
                                        <span class="text-xs text-gray-400 pl-2">{{ $message->created_at->format('H:i') }}</span>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    @endif
                </div>
            
                <div class="p-4 bg-white border-t border-gray-200">
                    <form id="chat-form" action="{{ route('chat.send') }}" method="POST" enctype="multipart/form-data" class="flex items-end space-x-4 bg-gray-50 p-2 rounded-3xl border border-gray-200 focus-within:ring-2 focus-within:ring-indigo-100 focus-within:border-indigo-300 transition-all shadow-sm">
                        @csrf
                        @if(isset($selected_user))
                            <input type="hidden" name="receiver_id" value="{{ $selected_user->id }}">
                        @endif
                        @if(isset($conversation))
                            <input type="hidden" name="conversation_id" value="{{ $conversation->id }}">
                        @endif

                    <input type="file" name="attachment" id="attachment" class="hidden" style="display: none;">
                    <button type="button" onclick="document.getElementById('attachment').click()" class="p-2 text-gray-400 hover:text-indigo-600 transition self-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13" />
                        </svg>
                    </button>

                    <div class="flex-1 relative">
                        <!-- File Preview Container -->
                        <div id="file-preview-container" class="hidden absolute bottom-full left-0 mb-2 w-full">
                            <div class="bg-indigo-50 rounded-2xl p-3 border border-indigo-100 shadow-lg inline-flex items-center space-x-3 animate-fade-in-up">
                                <div id="preview-icon-wrapper" class="relative">
                                    <img id="image-preview" src="" class="hidden w-16 h-16 object-cover rounded-xl border border-indigo-200">
                                    <div id="file-icon" class="hidden w-16 h-16 bg-white rounded-xl flex items-center justify-center border border-indigo-200 text-indigo-500">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                        </svg>
                                    </div>
                                    <button type="button" id="remove-file" class="absolute -top-2 -right-2 bg-red-500 text-white rounded-full p-1 shadow-md hover:bg-red-600 transition transform hover:scale-110">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                                        </svg>
                                    </button>
                                </div>
                                <div class="flex flex-col max-w-xs">
                                    <span id="file-name" class="text-sm font-semibold text-gray-700 truncate block"></span>
                                    <span id="file-size" class="text-xs text-gray-500"></span>
                                </div>
                            </div>
                        </div>

                        <textarea 
                            name="message"
                            id="message-input"
                            placeholder="Écrivez votre message..." 
                            class="w-full bg-transparent border-none focus:ring-0 resize-none py-3 text-gray-700 placeholder-gray-400 max-h-32"
                            rows="1"
                        ></textarea>
                    </div>
                    
                    <div class="flex items-center space-x-2 self-center pb-2">
                        <button type="button" class="p-2 text-gray-400 hover:text-yellow-500 transition">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </button>
                        
                        <button type="submit" class="bg-indigo-600 text-white rounded-full p-3 shadow-lg hover:bg-indigo-700 hover:shadow-xl transition transform hover:-translate-y-0.5">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                <path d="M10.894 2.553a1 1 0 00-1.788 0l-7 14a1 1 0 001.169 1.409l5-1.429A1 1 0 009 15.571V11a1 1 0 112 0v4.571a1 1 0 00.725.962l5 1.428a1 1 0 001.17-1.408l-7-14z" />
                            </svg>
                        </button>
                    </div>
                </form>
            </div>
                @else
                <div class="flex-1 flex flex-col justify-center items-center bg-slate-50">
                    <div class="text-center p-8 bg-white rounded-2xl shadow-sm border border-gray-100 max-w-md">
                        <div class="w-16 h-16 bg-indigo-100 text-indigo-600 rounded-full flex items-center justify-center mx-auto mb-4">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                            </svg>
                        </div>
                        <h2 class="text-2xl font-bold text-gray-900 mb-2">Vos messages</h2>
                        <p class="text-gray-500 mb-6">Sélectionnez une conversation dans la liste à gauche pour commencer à discuter.</p>
                        <a href="{{ route('friends.index') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-xl font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:border-indigo-900 focus:ring ring-indigo-300 disabled:opacity-25 transition ease-in-out duration-150">
                            Trouver des amis
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
        let messagesBox = document.querySelector('.flex-1.overflow-y-auto.p-6.space-y-6');

        if (messagesBox) {
            messagesBox.scrollTop = messagesBox.scrollHeight;
        }

        function addMessage(message) {

            if (!messagesBox) return;

            let isMe = message.sender_id == userId;

            let myImage = "{{ auth()->user()->image }}";
            let otherImage = "{{ isset($selected_user) ? $selected_user->image : '' }}";

            let img = myImage;

            let html = "";

            if (isMe) {
                let attachmentHtml = '';
                if(message.attach && message.attach.path) {
                    let path = "/storage/" + message.attach.path;
                    if(message.attach.mime_type.startsWith('image/')) {
                        attachmentHtml = `
                            <div class="mb-1">
                                <a href="${path}" target="_blank">
                                    <img src="${path}" class="max-w-[200px] max-h-[200px] rounded-lg shadow-sm border border-indigo-200 object-cover cursor-pointer hover:opacity-90 transition">
                                </a>
                            </div>`;
                    } else {
                        attachmentHtml = `
                            <div class="mb-1">
                                <a href="${path}" target="_blank" class="flex items-center space-x-2 bg-indigo-50 p-2 rounded-lg border border-indigo-100 hover:bg-indigo-100 transition shadow-sm max-w-[200px]">
                                    <div class="bg-indigo-100 p-2 rounded-lg text-indigo-500">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                        </svg>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <p class="text-xs font-medium text-indigo-900 truncate">${message.attach.filename}</p>
                                        <p class="text-[10px] text-indigo-500">${(message.attach.size / 1024).toFixed(1)} KB</p>
                                    </div>
                                </a>
                            </div>`;
                    }
                }

                html = `
                <div class="flex items-end justify-end space-x-2">
                    <div class="flex flex-col space-y-1 max-w-lg items-end">
                        ${attachmentHtml}
                        ${message.text ? `<div class="bg-indigo-600 px-4 py-3 rounded-2xl rounded-br-none text-white text-sm shadow-md leading-relaxed">${message.text}</div>` : ''}
                        <div class="flex items-center space-x-1 pr-1 justify-end">
                            <span class="text-xs text-gray-400">Maintenant</span>
                        </div>
                    </div>
                    <img src="${img}" class="w-8 h-8 rounded-full object-cover">
                </div>
                `;

            } else {
                let attachmentHtml = '';
                if(message.attach && message.attach.path) {
                    let path = "/storage/" + message.attach.path;
                    if(message.attach.mime_type && message.attach.mime_type.startsWith('image/')) {
                         attachmentHtml = `
                            <div class="mb-1">
                                <a href="${path}" target="_blank">
                                    <img src="${path}" class="max-w-[200px] max-h-[200px] rounded-lg shadow-sm border border-gray-100 object-cover cursor-pointer hover:opacity-90 transition">
                                </a>
                            </div>`;
                    } else {
                         attachmentHtml = `
                            <div class="mb-1">
                                <a href="${path}" target="_blank" class="flex items-center space-x-2 bg-gray-50 p-2 rounded-lg border border-gray-100 hover:bg-gray-100 transition shadow-sm max-w-[200px]">
                                    <div class="bg-gray-200 p-2 rounded-lg text-gray-500">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                        </svg>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <p class="text-xs font-medium text-gray-700 truncate">${message.attach.filename}</p>
                                        <p class="text-[10px] text-gray-400">${(message.attach.size / 1024).toFixed(1)} KB</p>
                                    </div>
                                </a>
                            </div>`;
                    }
                }

                html = `
                <div class="flex items-end space-x-2">
                    <img src="${img}" class="w-8 h-8 rounded-full object-cover">
                    <div class="flex flex-col space-y-1 max-w-lg">
                        ${attachmentHtml}
                        ${message.text ? `<div class="bg-white px-4 py-3 rounded-2xl rounded-bl-none shadow-sm text-gray-800 text-sm leading-relaxed border border-gray-100">${message.text}</div>` : ''}
                        <span class="text-xs text-gray-400 pl-2">Maintenant</span>
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
                    console.log(res);
                    if (res.success) {
                        textarea.value = "";
                        fileInput.value = ""; 
                        document.getElementById('file-preview-container').classList.add('hidden'); 
                        addMessage(res.message);
                    }

                })
                .catch(err => console.log(err));

            });
        }

        if (conversationId) {

            Echo.private("conversation." + conversationId)
                .listen(".message.sent", function (e) {
                    if (e.message.sender_id != userId) {
                        addMessage(e.message);
                    }

                });
        }

        const attachmentInput = document.getElementById('attachment');
        const previewContainer = document.getElementById('file-preview-container');
        const imagePreview = document.getElementById('image-preview');
        const fileIcon = document.getElementById('file-icon');
        const fileName = document.getElementById('file-name');
        const fileSize = document.getElementById('file-size');
        const removeFileBtn = document.getElementById('remove-file');

        attachmentInput.addEventListener('change', function() {
            const file = this.files[0];
            if (file) {
                
                previewContainer.classList.remove('hidden');
                fileName.textContent = file.name;
                fileSize.textContent = formatBytes(file.size);

                if (file.type.startsWith('image/')) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
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

        removeFileBtn.addEventListener('click', function() {
            attachmentInput.value = '';
            previewContainer.classList.add('hidden');
        });

        function formatBytes(bytes, decimals = 2) {
            if (bytes === 0) return '0 Bytes';
            const k = 1024;
            const dm = decimals < 0 ? 0 : decimals;
            const sizes = ['Bytes', 'KB', 'MB', 'GB', 'TB'];
            const i = Math.floor(Math.log(bytes) / Math.log(k));
            return parseFloat((bytes / Math.pow(k, i)).toFixed(dm)) + ' ' + sizes[i];
        }

    });
</script>
</x-app-layout>
