<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-white">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Talentia') }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Outfit', sans-serif; }
    </style>
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="h-full">
    <div class="flex min-h-full">
        <div class="flex flex-1 flex-col justify-center px-4 py-12 sm:px-6 lg:flex-none lg:px-20 xl:px-24 bg-white z-10 relative">
            <div class="mx-auto w-full max-w-sm lg:w-96">
                <div>
                   <a href="/" class="flex items-center gap-2 group">
                        <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-indigo-600 text-white shadow-indigo-200 shadow-lg group-hover:scale-110 transition-transform duration-300">
                             <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6">
                              <path stroke-linecap="round" stroke-linejoin="round" d="M15.59 14.37a6 6 0 01-5.84 7.38v-4.8m5.84-2.58a14.98 14.98 0 006.16-12.12A14.98 14.98 0 009.631 8.41m5.96 5.96a14.926 14.926 0 01-5.841 2.58m-.119-8.54a6 6 0 00-7.381 5.84h4.8m2.581-5.84a14.927 14.927 0 00-2.58 5.84m2.699 2.7c-.103.021-.207.041-.311.06a15.09 15.09 0 01-2.448-2.448 14.9 14.9 0 01.06-.312m-2.24 2.39a4.493 4.493 0 00-1.757 4.306 4.493 4.493 0 004.306-1.758M16.5 9a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0z" />
                            </svg>
                        </div>
                        <span class="text-2xl font-bold bg-clip-text text-transparent bg-gradient-to-r from-gray-900 to-gray-600">
                            Talentia
                        </span>
                    </a>
                    
                    {{ $header ?? '' }}
                </div>

                <div class="mt-8">
                    {{ $slot }}
                </div>
            </div>
        </div>
        
        <!-- Right Image Section -->
        <div class="relative hidden w-0 flex-1 lg:block">
            <div class="absolute inset-0 h-full w-full object-cover bg-gradient-to-br from-indigo-600 to-violet-600">
                 <!-- Overlay Patterns -->
                <div class="absolute inset-0 bg-[url('https://grainy-gradients.vercel.app/noise.svg')] opacity-20 brightness-100 contrast-150"></div>
                
                 <!-- Floating shapes/content -->
                <div class="flex items-center justify-center h-full relative z-10 px-20 text-center text-white">
                    <div>
                        <h2 class="text-5xl font-extrabold tracking-tight mb-6 leading-tight">
                            Connect with <br/> <span class="text-indigo-200">Top Talent</span>
                        </h2>
                        <p class="text-lg text-indigo-100 max-w-lg mx-auto leading-relaxed">
                            Join thousands of professionals and companies building the future of work. Simple, fast, and efficient.
                        </p>
                        
                        <!-- Testimonial or Stats -->
                         <div class="mt-12 flex items-center justify-center gap-4">
                            <div class="flex -space-x-4">
                                <img class="w-10 h-10 rounded-full border-2 border-white" src="https://i.pravatar.cc/100?img=1" alt="">
                                <img class="w-10 h-10 rounded-full border-2 border-white" src="https://i.pravatar.cc/100?img=5" alt="">
                                <img class="w-10 h-10 rounded-full border-2 border-white" src="https://i.pravatar.cc/100?img=8" alt="">
                                <div class="w-10 h-10 rounded-full border-2 border-white bg-white/20 flex items-center justify-center text-xs font-bold">+2k</div>
                            </div>
                            <div class="text-left">
                                <p class="font-bold text-white text-sm">Community</p>
                                <div class="flex text-yellow-400 text-xs">
                                    ★ ★ ★ ★ ★
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
