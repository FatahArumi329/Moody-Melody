<x-guest-layout>
    <form method="POST" action="{{ route('login') }}" class="bg-white dark:bg-gray-800 p-8 rounded-xl shadow-lg">
        @csrf

        <h2 class="text-2xl font-bold mb-6 text-dark-teal dark:text-off-white text-center">Welcome Back!</h2>

        @if (session('success'))
            <div class="mb-4 text-sm text-green-600 dark:text-green-400">
                {{ session('success') }}
            </div>
        @endif

        <!-- Username -->
        <div>
            <x-input-label for="username" :value="__('Username')" class="text-dark-teal dark:text-off-white" />
            <x-text-input id="username" 
                         class="block mt-1 w-full bg-off-white dark:bg-gray-700 text-dark-teal dark:text-off-white border-gray-300 dark:border-gray-600 focus:border-orange focus:ring-orange" 
                         type="text" 
                         name="username" 
                         :value="old('username')" 
                         required 
                         autofocus />
            <x-input-error :messages="$errors->get('username')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4 relative">
            <x-input-label for="password" :value="__('Password')" class="text-dark-teal dark:text-off-white" />
            <div class="relative">
                <x-text-input id="password" 
                             class="block mt-1 w-full bg-off-white dark:bg-gray-700 text-dark-teal dark:text-off-white border-gray-300 dark:border-gray-600 focus:border-orange focus:ring-orange pr-10"
                             type="password"
                             name="password"
                             required />
                <button type="button" 
                        onclick="togglePasswordVisibility()"
                        class="absolute inset-y-0 right-0 flex items-center pr-3 mt-1 text-dark-teal dark:text-off-white">
                    <svg id="eye-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                    <svg id="eye-slash-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 hidden">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.498a10.523 10.523 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.894 7.894L21 21m-3.228-3.228l-3.65-3.65m0 0a3 3 0 10-4.243-4.243m4.242 4.242L9.88 9.88" />
                    </svg>
                </button>
            </div>
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="block mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" 
                       type="checkbox" 
                       class="rounded bg-off-white dark:bg-gray-700 border-gray-300 dark:border-gray-600 text-orange focus:ring-orange dark:focus:ring-orange" 
                       name="remember">
                <span class="ml-2 text-sm text-dark-teal dark:text-off-white">{{ __('Remember me') }}</span>
            </label>
        </div>

        <div class="flex items-center justify-end mt-4">
            @if (Route::has('register'))
                <a class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800" href="{{ route('register') }}">
                    {{ __('Don\'t have an account? Register now') }}
                </a>
            @endif

            <x-primary-button class="ml-3">
                {{ __('Login') }}
            </x-primary-button>
        </div>
    </form>

    <script>
        function togglePasswordVisibility() {
            const passwordInput = document.getElementById('password');
            const eyeIcon = document.getElementById('eye-icon');
            const eyeSlashIcon = document.getElementById('eye-slash-icon');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                eyeIcon.classList.add('hidden');
                eyeSlashIcon.classList.remove('hidden');
            } else {
                passwordInput.type = 'password';
                eyeIcon.classList.remove('hidden');
                eyeSlashIcon.classList.add('hidden');
            }
        }
    </script>
</x-guest-layout>