<x-app-layout>
    <div class="bg-gray-50 min-h-screen py-12">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="mb-10 text-center">
                <h1 class="text-3xl font-extrabold text-slate-900">Secure Checkout</h1>
                <p class="mt-2 text-slate-500">Complete your upgrade to {{ $selectedPlan['name'] }}</p>
            </div>

            <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-slate-100">
                <div class="grid grid-cols-1 md:grid-cols-2">
                    
                    <!-- Order Summary (Left/Top) -->
                    <div class="bg-slate-50 p-8 border-b md:border-b-0 md:border-r border-slate-100">
                        <h2 class="text-lg font-semibold text-slate-900 mb-6">Order Summary</h2>
                        
                        <div class="flex justify-between items-center mb-4">
                            <span class="text-slate-600 font-medium">{{ $selectedPlan['name'] }} Plan</span>
                            <span class="text-slate-900 font-bold">${{ $selectedPlan['price'] }}<span class="text-slate-500 font-normal text-sm">/{{ $selectedPlan['interval'] }}</span></span>
                        </div>

                        <ul class="space-y-3 mb-8">
                            @foreach($selectedPlan['features'] as $feature)
                            <li class="flex items-start text-sm text-slate-500">
                                <svg class="w-4 h-4 text-green-500 mr-2 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                {{ $feature }}
                            </li>
                            @endforeach
                        </ul>

                        <div class="border-t border-slate-200 pt-4 mt-4">
                             <div class="flex justify-between items-center">
                                <span class="text-slate-900 font-bold">Total due today</span>
                                <span class="text-2xl font-extrabold text-indigo-600">${{ $selectedPlan['price'] }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Payment Details (Right/Bottom) -->
                    <div class="p-8">
                        <h2 class="text-lg font-semibold text-slate-900 mb-6">Payment Details</h2>
                        
                        <form action="#" method="POST" class="space-y-5">
                            @csrf
                            
                            <!-- Email -->
                            <div>
                                <label for="email" class="block text-sm font-medium text-slate-700 mb-1">Email Address</label>
                                <input type="email" name="email" id="email" value="{{ auth()->user()->email }}" class="block w-full rounded-lg border-gray-300 bg-gray-50 text-gray-500 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" readonly>
                            </div>

                            <!-- Card Holder -->
                            <div>
                                <label for="card-holder" class="block text-sm font-medium text-slate-700 mb-1">Card Holder Name</label>
                                <input type="text" name="name" id="card-holder" value="{{ auth()->user()->name }}" class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" placeholder="John Doe">
                            </div>

                            <!-- Stripe Element Placeholder -->
                            <div>
                                <label class="block text-sm font-medium text-slate-700 mb-1">Card Information</label>
                                <div class="block w-full rounded-lg border border-gray-300 bg-white p-3 shadow-sm">
                                    <div id="card-element">
                                        <!-- A Stripe Element will be inserted here. -->
                                        <div class="flex items-center space-x-2 text-gray-400">
                                            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path></svg>
                                            <span class="text-sm">Card number &nbsp; MM/YY &nbsp; CVC</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <button type="button" class="mt-6 w-full flex justify-center py-3 px-4 border border-transparent rounded-xl shadow-sm text-sm font-bold text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all">
                                Pay ${{ $selectedPlan['price'] }} Securely
                            </button>
                            
                            <p class="text-xs text-center text-slate-400 mt-4">
                                <svg class="w-3 h-3 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                                Payments are secure and encrypted.
                            </p>
                        </form>
                    </div>
                </div>
            </div>
             <div class="mt-8 text-center">
                <a href="{{ route('premium') }}" class="text-sm font-medium text-indigo-600 hover:text-indigo-500">
                    &larr; Back to Plans
                </a>
            </div>
        </div>
    </div>
</x-app-layout>
