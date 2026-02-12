<x-auth-split-layout>
    <x-slot name="header">
        <h2 class="mt-6 text-3xl font-bold tracking-tight text-gray-900">
            Create an account
        </h2>
        <p class="mt-2 text-sm text-gray-600">
            Already have an account?
            <a href="{{ route('login') }}" class="font-medium text-indigo-600 hover:text-indigo-500">
                Sign in
            </a>
        </p>
    </x-slot>

    <div class="mt-8">
        <div>
           
                <p class="text-sm font-medium text-gray-700">Sign up with</p>

                <div class="mt-2 grid grid-cols-2 gap-3">
                    <!-- Google -->
                    <div>
                        <a href="{{ route('google.redirect') }}" class="inline-flex w-full justify-center rounded-md border border-gray-300 bg-white py-2 px-4 text-sm font-medium text-gray-500 shadow-sm hover:bg-gray-50 transition-colors">
                            <span class="sr-only">Sign up with Google</span>
                            <svg class="h-5 w-5" aria-hidden="true" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12.48 10.92v3.28h7.84c-.24 1.84-.853 3.187-1.787 4.133-1.147 1.147-2.933 2.4-6.053 2.4-4.827 0-8.6-3.893-8.6-8.72s3.773-8.72 8.6-8.72c2.6 0 4.507 1.027 5.907 2.347l2.307-2.307C18.747 1.44 16.133 0 12.48 0 5.867 0 .533 5.333.533 12S5.867 24 12.48 24c3.44 0 6.027-1.133 8.16-3.293 2.16-2.16 2.84-5.213 2.84-7.667 0-.76-.053-1.467-.173-2.133H12.48z" />
                            </svg>
                        </a>
                    </div>
                    
                    <!-- GitHub -->
                    <div>
                        <a href="{{ route('auth.github') }}" class="inline-flex w-full justify-center rounded-md border border-gray-300 bg-white py-2 px-4 text-sm font-medium text-gray-500 shadow-sm hover:bg-gray-50 transition-colors">
                            <span class="sr-only">Sign up with GitHub</span>
                            <svg class="h-5 w-5" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 0C4.477 0 0 4.484 0 10.017c0 4.425 2.865 8.18 6.839 9.504.5.092.682-.217.682-.483 0-.237-.008-.868-.013-1.703-2.782.605-3.369-1.343-3.369-1.343-.454-1.158-1.11-1.466-1.11-1.466-.908-.62.069-.608.069-.608 1.003.07 1.531 1.032 1.531 1.032.892 1.53 2.341 1.088 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.113-4.555-4.951 0-1.093.39-1.988 1.029-2.688-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.026A9.564 9.564 0 0110 4.844c.85.004 1.705.115 2.504.337 1.909-1.296 2.747-1.027 2.747-1.027.546 1.379.202 2.398.1 2.651.64.7 1.028 1.595 1.028 2.688 0 3.848-2.339 4.695-4.566 4.943.359.309.678.92.678 1.855 0 1.338-.012 2.419-.012 2.747 0 .268.18.58.688.482A10.019 10.019 0 0020 10.017C20 4.484 15.522 0 10 0z" clip-rule="evenodd" />
                            </svg>
                        </a>
                    </div>
                </div>

            <div class="mt-6">
                <div class="relative">
                    <div class="absolute inset-0 flex items-center">
                        <div class="w-full border-t border-gray-300"></div>
                    </div>
                    <div class="relative flex justify-center text-sm">
                        <span class="bg-white px-2 text-gray-500">Or register with email</span>
                    </div>
                </div>

                <div class="mt-6">
                    <form action="{{ route('register') }}" method="POST" class="space-y-4">
                        @csrf
                        
                        <div class="grid grid-cols-2 gap-4">
                            <!-- Nom -->
                            <div>
                                <label for="nom" class="block text-sm font-medium text-gray-700">Nom</label>
                                <div class="mt-1">
                                    <input id="nom" name="nom" type="text" required class="block w-full appearance-none rounded-lg border border-gray-300 px-3 py-2 shadow-sm focus:border-indigo-500 focus:outline-none focus:ring-indigo-500 sm:text-sm" value="{{ old('nom') }}">
                                </div>
                                <x-input-error :messages="$errors->get('nom')" class="mt-2" />
                            </div>
                            <!-- Prénom -->
                            <div>
                                <label for="prenom" class="block text-sm font-medium text-gray-700">Prénom</label>
                                <div class="mt-1">
                                    <input id="prenom" name="prenom" type="text" required class="block w-full appearance-none rounded-lg border border-gray-300 px-3 py-2 shadow-sm focus:border-indigo-500 focus:outline-none focus:ring-indigo-500 sm:text-sm" value="{{ old('prenom') }}">
                                </div>
                                <x-input-error :messages="$errors->get('prenom')" class="mt-2" />
                            </div>
                        </div>

                        <!-- Email -->
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700">Email address</label>
                            <div class="mt-1">
                                <input id="email" name="email" type="email" autocomplete="email" required class="block w-full appearance-none rounded-lg border border-gray-300 px-3 py-2 shadow-sm focus:border-indigo-500 focus:outline-none focus:ring-indigo-500 sm:text-sm" value="{{ old('email') }}">
                            </div>
                            <x-input-error :messages="$errors->get('email')" class="mt-2" />
                        </div>

                        <!-- Role -->
                         <div>
                            <label for="role" class="block text-sm font-medium text-gray-700">I am a</label>
                            <div class="mt-1">
                                <select id="role" name="role" required class="block w-full rounded-lg border-gray-300 px-3 py-2 shadow-sm focus:border-indigo-500 focus:outline-none focus:ring-indigo-500 sm:text-sm">
                                    <option value="" disabled selected>Select your role</option>
                                    <option value="RECRUTEUR" {{ old('role') == 'RECRUTEUR' ? 'selected' : '' }}>Recruiter (Hiring Talent)</option>
                                    <option value="RECHERCHEUR" {{ old('role') == 'RECHERCHEUR' ? 'selected' : '' }}>Job Seeker (Looking for jobs)</option>
                                </select>
                            </div>
                            <x-input-error :messages="$errors->get('role')" class="mt-2" />
                        </div>
                        
                        <!-- Image URL (Hidden/Optional or Styled) -->
                        <div>
                            <label for="image" class="block text-sm font-medium text-gray-700">Profile Image URL <span class="text-xs text-gray-400">(Optional)</span></label>
                            <div class="mt-1">
                                 <input id="image" name="image" type="url" class="block w-full appearance-none rounded-lg border border-gray-300 px-3 py-2 shadow-sm focus:border-indigo-500 focus:outline-none focus:ring-indigo-500 sm:text-sm" placeholder="https://example.com/avatar.jpg">
                            </div>
                             <x-input-error :messages="$errors->get('image')" class="mt-2" />
                        </div>


                        <div class="grid grid-cols-2 gap-4">
                            <!-- Password -->
                            <div>
                                <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                                <div class="mt-1">
                                    <input id="password" name="password" type="password" required class="block w-full appearance-none rounded-lg border border-gray-300 px-3 py-2 shadow-sm focus:border-indigo-500 focus:outline-none focus:ring-indigo-500 sm:text-sm">
                                </div>
                            </div>
                             <!-- Confirm Password -->
                            <div>
                                <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirm</label>
                                <div class="mt-1">
                                    <input id="password_confirmation" name="password_confirmation" type="password" required class="block w-full appearance-none rounded-lg border border-gray-300 px-3 py-2 shadow-sm focus:border-indigo-500 focus:outline-none focus:ring-indigo-500 sm:text-sm">
                                </div>
                            </div>
                        </div>
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />


                        <div>
                            <button type="submit" class="flex w-full justify-center rounded-lg border border-transparent bg-indigo-600 py-3 px-4 text-sm font-bold text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition-all">
                                Create Account
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-auth-split-layout>