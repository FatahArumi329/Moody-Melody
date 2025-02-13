<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('My Playlists') }}
            </h2>
            <a href="{{ route('playlists.create') }}" 
               class="inline-flex items-center px-4 py-2 bg-[#D2601A] border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-[#b24914] focus:outline-none focus:border-[#d2601a1a] focus:ring ring-[#d2601a1a] disabled:opacity-25 transition ease-in-out duration-150">
                {{ __('Create New Playlist') }}
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            @if($playlists->isEmpty())
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-center">
                        <p class="text-gray-600 dark:text-gray-400">You haven't created any playlists yet.</p>
                        <a href="{{ route('playlists.create') }}" 
                           class="inline-block mt-4 px-4 py-2 bg-[#D2601A] text-white rounded-md hover:bg-[#b24914] transition">
                            Create Your First Playlist
                        </a>
                    </div>
                </div>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($playlists as $playlist)
                        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                            <div class="p-6">
                                <div class="flex justify-between items-start">
                                    <div>
                                        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">
                                            {{ $playlist->name }}
                                        </h3>
                                        <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">
                                            {{ $playlist->songs->count() }} songs
                                        </p>
                                        @if($playlist->description)
                                            <p class="text-sm text-gray-600 dark:text-gray-400 mt-2">
                                                {{ Str::limit($playlist->description, 100) }}
                                            </p>
                                        @endif
                                    </div>
                                    <div class="flex space-x-2">
                                        <a href="{{ route('playlists.show', $playlist) }}" 
                                           class="text-[#D2601A] hover:text-[#b24914]"
                                           title="View Playlist">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            </svg>
                                        </a>
                                        <form action="{{ route('playlists.destroy', $playlist) }}" 
                                              method="POST" 
                                              class="inline"
                                              onsubmit="return confirm('Are you sure you want to delete this playlist?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                    class="text-red-600 hover:text-red-800"
                                                    title="Delete Playlist">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
