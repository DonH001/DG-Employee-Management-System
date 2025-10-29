<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-6" :status="session('status')" />

    <div class="text-center mb-8">
        <h2 class="text-3xl font-bold text-gray-900 mb-2">Welcome Back</h2>
        <p class="text-gray-600">Sign in to DG Computer EMS</p>
    </div>

    <form method="POST" action="{{ route('login') }}" class="space-y-6">
        @csrf

        <!-- Email Address -->
        <div class="space-y-2">
            <x-input-label for="email" :value="__('Email Address')" class="text-sm font-semibold text-gray-700" />
            <x-text-input id="email" 
                class="block w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-200" 
                type="email" 
                name="email" 
                :value="old('email')" 
                placeholder="Enter your email address"
                required 
                autofocus 
                autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="space-y-2">
            <x-input-label for="password" :value="__('Password')" class="text-sm font-semibold text-gray-700" />
            <x-text-input id="password" 
                class="block w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-200" 
                type="password" 
                name="password" 
                placeholder="Enter your password"
                required 
                autocomplete="current-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me & Forgot Password -->
        <div class="flex items-center justify-between">
            <label for="remember_me" class="flex items-center">
                <input id="remember_me" type="checkbox" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 focus:ring-2" name="remember">
                <span class="ml-2 text-sm text-gray-600">Remember me</span>
            </label>

            @if (Route::has('password.request'))
                <a class="text-sm text-blue-600 hover:text-blue-800 font-medium transition duration-200" href="{{ route('password.request') }}">
                    Forgot password?
                </a>
            @endif
        </div>

        <!-- Login Button -->
        <div class="pt-2">
            <x-primary-button class="w-full justify-center py-3 text-base">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path>
                </svg>
                Sign In
            </x-primary-button>
        </div>

        <!-- Demo Credentials -->
        <div class="mt-8 pt-6 border-t border-gray-200">
            <div class="bg-blue-50 rounded-lg p-4">
                <div class="flex items-center mb-3">
                    <svg class="w-5 h-5 text-blue-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <h4 class="text-sm font-semibold text-blue-900">Demo Credentials</h4>
                </div>
                <div class="space-y-2 text-sm text-blue-800">
                    <div class="flex justify-between items-center p-2 bg-white rounded border border-blue-200">
                        <span class="font-medium">Administrator</span>
                        <code class="text-xs bg-gray-100 px-2 py-1 rounded">admin@company.com</code>
                    </div>
                    <div class="flex justify-between items-center p-2 bg-white rounded border border-blue-200">
                        <span class="font-medium">HR Manager</span>
                        <code class="text-xs bg-gray-100 px-2 py-1 rounded">hr@company.com</code>
                    </div>
                    <div class="flex justify-between items-center p-2 bg-white rounded border border-blue-200">
                        <span class="font-medium">Employee</span>
                        <code class="text-xs bg-gray-100 px-2 py-1 rounded">employee@company.com</code>
                    </div>
                    <p class="text-center text-xs text-blue-600 mt-2 font-medium">
                        Password for all accounts: <code class="bg-white px-1 rounded">password123</code>
                    </p>
                </div>
            </div>
        </div>
    </form>
</x-guest-layout>