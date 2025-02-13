<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Detect Your Mood') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    @if (session('error'))
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                            <span class="block sm:inline">{{ session('error') }}</span>
                        </div>
                    @endif

                    <!-- Available Moods -->
                    <div class="mb-6 bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                        <ul class="list-disc list-inside space-y-2 text-gray-600 dark:text-gray-400">
                            <li><span class="font-medium">Happy 😊</span> - Joyful, excited, cheerful</li>
                            <li><span class="font-medium">Sad 😢</span> - Melancholic, down, blue</li>
                            <li><span class="font-medium">Energetic ⚡</span> - Dynamic, pumped, motivated</li>
                            <li><span class="font-medium">Relaxed 😌</span> - Calm, peaceful, serene</li>
                            <li><span class="font-medium">Focused 🎯</span> - Concentrated, determined</li>
                        </ul>
                        <p class="mt-4 text-sm text-gray-600 dark:text-gray-400">
                            Select your current mood, and we'll find the perfect songs for your current state of mind!
                        </p>
                    </div>

                    <form action="{{ route('moods.songs', ['mood' => ':mood']) }}" method="GET" class="space-y-6" id="moodForm">
                        @csrf
                        
                        <div>
                            <label for="text" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                Select your mood
                            </label>
                            <div class="mt-1">
                                <select
                                    id="text"
                                    name="text"
                                    required
                                    onchange="submitForm(this.value)"
                                    class="block w-full mt-1 rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-[#D2601A] focus:ring focus:ring-[#d2601a1a] focus:ring-opacity-50"
                                >
                                    <option value="">Choose a mood...</option>
                                    <option value="happy">Happy 😊</option>
                                    <option value="sad">Sad 😢</option>
                                    <option value="energetic">Energetic ⚡</option>
                                    <option value="relaxed">Relaxed 😌</option>
                                    <option value="focused">Focused 🎯</option>
                                </select>
                            </div>
                        </div>

                        <script>
                        function submitForm(mood) {
                            if (mood) {
                                window.location.href = '/moods/' + mood + '/songs';
                            }
                        }
                        </script>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
