<x-app-layout>
    <div class="bg-white min-h-screen font-sans">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20">
            
            <!-- Header -->
            <div class="text-center max-w-3xl mx-auto mb-20">
                <h2 class="text-indigo-600 font-semibold tracking-wide uppercase text-sm mb-2">Plans & Pricing</h2>
                <h1 class="text-5xl font-extrabold text-slate-900 tracking-tight mb-4">
                    Simple, transparent pricing
                </h1>
                <p class="text-xl text-slate-500 font-light">
                    Choose the plan that fits your ambition. No hidden fees. Cancel anytime.
                </p>
            </div>

            @if(auth()->user()->subscribed('default'))
                <div class="max-w-3xl mx-auto text-center bg-white rounded-3xl border border-indigo-100 shadow-xl p-12">
                    <div class="w-20 h-20 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-6">
                        <svg class="w-10 h-10 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                    </div>
                    <h2 class="text-3xl font-bold text-slate-900 mb-4">You are already Premium!</h2>
                    <p class="text-lg text-slate-600 mb-8">
                        Your subscription is active. You have full access to all premium features.
                    </p>
                    <div class="bg-slate-50 rounded-xl p-6 mb-8 text-left max-w-md mx-auto">
                         <div class="flex justify-between items-center mb-2">
                            <span class="text-slate-500">Status</span>
                            <span class="font-bold text-green-600 bg-green-50 px-3 py-1 rounded-full text-sm">Active</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-slate-500">Ends at</span>
                            <span class="font-medium text-slate-900">
                                {{ auth()->user()->subscription('default')->ends_at?->format('F j, Y') ?? 'Auto-renews' }}
                            </span>
                        </div>
                    </div>
                    
                    <a href="{{ route('dashboard.rechercheur') }}" class="inline-block py-3 px-8 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-xl transition-all shadow-lg hover:shadow-indigo-500/30">
                        Go to Dashboard
                    </a>
                </div>
            @else
            <div class="grid grid-cols-1 md:grid-cols-3 gap-10 max-w-7xl mx-auto">
                
                <!-- Free Plan -->
                <div class="bg-white rounded-3xl border border-slate-100 shadow-xl shadow-slate-200/50 p-10 flex flex-col transition-all duration-300 hover:shadow-2xl hover:scale-[1.02]">
                    <div class="mb-6">
                        <span class="inline-block py-1 px-3 rounded-full bg-slate-50 text-slate-600 text-xs font-bold uppercase tracking-wider">
                            Starter
                        </span>
                        <h3 class="text-4xl font-bold text-slate-900 mt-4">Free</h3>
                        <p class="text-slate-500 mt-2">Forever free for individuals.</p>
                    </div>
                    
                    <ul class="space-y-4 mb-8 flex-1">
                        <li class="flex items-start">
                            <svg class="w-5 h-5 text-indigo-500 mr-3 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            <span class="text-slate-600">Access to basic job listings</span>
                        </li>
                        <li class="flex items-start">
                            <svg class="w-5 h-5 text-indigo-500 mr-3 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            <span class="text-slate-600">Create a professional profile</span>
                        </li>
                        <li class="flex items-start">
                            <svg class="w-5 h-5 text-indigo-500 mr-3 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            <span class="text-slate-600">Apply to 3 jobs per month</span>
                        </li>
                    </ul>

                    <a href="{{ route('checkout', ['plan' => 'free']) }}" class="block w-full py-4 px-6 bg-slate-50 hover:bg-slate-100 text-slate-900 font-semibold rounded-xl text-center transition-colors border border-slate-200">
                        Get Started
                    </a>
                </div>

                <!-- Pro Plan (Popular) -->
                <div class="bg-white rounded-3xl border-2 border-indigo-600 shadow-2xl shadow-indigo-200/50 p-10 flex flex-col relative transform scale-105 z-10">
                    <div class="absolute top-0 right-0 -mt-4 mr-4 bg-indigo-600 text-white text-xs font-bold px-3 py-1 rounded-full uppercase tracking-wider shadow-md">
                        Most Popular
                    </div>
                    <div class="mb-6">
                        <span class="inline-block py-1 px-3 rounded-full bg-indigo-50 text-indigo-600 text-xs font-bold uppercase tracking-wider">
                            Professional
                        </span>
                        <div class="flex items-baseline mt-4">
                            <span class="text-5xl font-extrabold text-slate-900">$29</span>
                            <span class="text-slate-500 ml-1">/mo</span>
                        </div>
                        <p class="text-slate-500 mt-2">Everything you need to grow.</p>
                    </div>
                    
                    <ul class="space-y-4 mb-8 flex-1">
                        <li class="flex items-start">
                            <svg class="w-6 h-6 text-indigo-600 mr-3 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            <span class="text-slate-700 font-medium">Unlimited Job Applications</span>
                        </li>
                        <li class="flex items-start">
                            <svg class="w-6 h-6 text-indigo-600 mr-3 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            <span class="text-slate-700 font-medium">Featured Applicant Status</span>
                        </li>
                        <li class="flex items-start">
                            <svg class="w-6 h-6 text-indigo-600 mr-3 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            <span class="text-slate-700 font-medium">See Who Viewed Profile</span>
                        </li>
                         <li class="flex items-start">
                            <svg class="w-6 h-6 text-indigo-600 mr-3 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            <span class="text-slate-700 font-medium">Priority Support</span>
                        </li>
                    </ul>

                    <a href="{{ route('checkout', ['plan' => 'pro']) }}" class="block w-full py-4 px-6 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-xl text-center shadow-lg shadow-indigo-500/30 transition-all hover:shadow-indigo-500/50">
                        Upgrade Now
                    </a>
                </div>

                <!-- Enterprise Plan -->
                <div class="bg-white rounded-3xl border border-slate-100 shadow-xl shadow-slate-200/50 p-10 flex flex-col transition-all duration-300 hover:shadow-2xl hover:scale-[1.02]">
                    <div class="mb-6">
                        <span class="inline-block py-1 px-3 rounded-full bg-blue-50 text-blue-600 text-xs font-bold uppercase tracking-wider">
                            Business
                        </span>
                        <div class="flex items-baseline mt-4">
                            <span class="text-4xl font-bold text-slate-900">$99</span>
                            <span class="text-slate-500 ml-1">/mo</span>
                        </div>
                        <p class="text-slate-500 mt-2">For recruiters and teams.</p>
                    </div>
                    
                    <ul class="space-y-4 mb-8 flex-1">
                        <li class="flex items-start">
                            <svg class="w-5 h-5 text-blue-500 mr-3 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            <span class="text-slate-600">Post Unlimited Jobs</span>
                        </li>
                        <li class="flex items-start">
                            <svg class="w-5 h-5 text-blue-500 mr-3 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            <span class="text-slate-600">Advanced Candidate Search</span>
                        </li>
                        <li class="flex items-start">
                            <svg class="w-5 h-5 text-blue-500 mr-3 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            <span class="text-slate-600">Team Management</span>
                        </li>
                    </ul>

                    <a href="{{ route('checkout', ['plan' => 'business']) }}" class="block w-full py-4 px-6 bg-white hover:bg-slate-50 text-slate-900 font-semibold rounded-xl text-center transition-colors border-2 border-slate-100">
                        Contact Sales
                    </a>
                </div>
            </div>
            @endif

            <!-- Trust Badge / Footer subtle -->
            <div class="mt-20 text-center border-t border-slate-100 pt-10">
                <p class="text-slate-400 text-sm">Trusted by over 1,000+ professionals and companies</p>
                <div class="flex justify-center space-x-6 mt-6 opacity-40 grayscale">
                   <!-- Placeholders for logos if needed, sticking to text for cleanliness -->
                   <span class="text-xl font-bold text-slate-300">COMPANY</span>
                   <span class="text-xl font-bold text-slate-300">STARTUP</span>
                   <span class="text-xl font-bold text-slate-300">AGENCY</span>
                   <span class="text-xl font-bold text-slate-300">CORP</span>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
