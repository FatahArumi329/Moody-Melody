<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Mood Detection Card -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">
                            Mood Detection
                        </h3>
                        <p class="text-gray-600 dark:text-gray-400 mb-4">
                            Let us help you find the perfect songs based on your current mood.
                        </p>
                        <a href="{{ route('moods.custom') }}" 
                           class="inline-flex items-center px-4 py-2 bg-[#D2601A] border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-[#b24914] focus:outline-none focus:border-[#d2601a1a] focus:ring ring-[#d2601a1a] disabled:opacity-25 transition ease-in-out duration-150">
                            Detect My Mood
                        </a>
                    </div>
                </div>

                <!-- Playlist Management Card -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">
                            Playlist Management
                        </h3>
                        <p class="text-gray-600 dark:text-gray-400 mb-4">
                            Create and manage your personalized playlists.
                        </p>
                        <div class="space-x-4">
                            <a href="{{ route('playlists.create') }}" 
                               class="inline-flex items-center px-4 py-2 bg-[#D2601A] border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-[#b24914] focus:outline-none focus:border-[#d2601a1a] focus:ring ring-[#d2601a1a] disabled:opacity-25 transition ease-in-out duration-150">
                                Create Playlist
                            </a>
                            <a href="{{ route('playlists.index') }}" 
                               class="inline-flex items-center px-4 py-2 bg-gray-200 dark:bg-gray-700 border border-transparent rounded-md font-semibold text-xs text-gray-700 dark:text-gray-300 uppercase tracking-widest hover:bg-gray-300 dark:hover:bg-gray-600 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">
                                View Playlists
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
