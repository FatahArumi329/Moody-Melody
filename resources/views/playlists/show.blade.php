<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ $playlist->name }}
            </h2>
            <div class="flex items-center gap-4">
                <a href="{{ route('playlists.edit', $playlist) }}" 
                   class="px-4 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600 transition">
                    Edit Playlist
                </a>
                <form action="{{ route('playlists.destroy', $playlist) }}" method="POST" class="inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" 
                            class="px-4 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600 transition"
                            onclick="return confirm('Are you sure you want to delete this playlist?')">
                        Delete Playlist
                    </button>
                </form>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    @if(session('success'))
                        <div class="px-6 pt-6">
                            <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                                <span class="block sm:inline">{{ session('success') }}</span>
                            </div>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="px-6 pt-6">
                            <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                                <span class="block sm:inline">{{ session('error') }}</span>
                            </div>
                        </div>
                    @endif

                    <div class="flex justify-between items-center mb-4">
                        <h6 class="text-lg font-medium text-gray-900 dark:text-gray-100">Songs in this playlist:</h6>
                    </div>

                    @if($playlist->songs->isEmpty())
                        <div class="p-6 text-center">
                            <p class="text-gray-500 dark:text-gray-400 text-lg">No songs in this playlist yet.</p>
                        </div>
                    @else
                        <div class="overflow-x-auto">
                            <table class="w-full divide-y divide-gray-200 dark:divide-gray-700">
                                <thead>
                                    <tr class="bg-gray-50 dark:bg-gray-700">
                                        <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-500 dark:text-gray-300 uppercase tracking-wider w-2/5">
                                            Song Title
                                        </th>
                                        <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-500 dark:text-gray-300 uppercase tracking-wider w-2/5">
                                            Artist
                                        </th>
                                        <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-500 dark:text-gray-300 uppercase tracking-wider w-1/5">
                                            Actions
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700">
                                    @foreach($playlist->songs as $song)
                                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors duration-200">
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="flex items-center">
                                                    <div class="text-sm font-medium text-gray-900 dark:text-white">
                                                        {{ $song->title }}
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm text-gray-900 dark:text-white">
                                                    {{ $song->artist }}
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium space-x-3">
                                                <a href="{{ route('songs.details', ['title' => urlencode($song->title), 'artist' => urlencode($song->artist)]) }}" 
                                                    class="inline-flex items-center px-3 py-1.5 border border-indigo-500 text-sm leading-5 font-medium rounded-md text-indigo-500 bg-white dark:bg-gray-800 hover:text-white hover:bg-indigo-500 focus:outline-none focus:shadow-outline-indigo active:bg-indigo-600 transition-colors"
                                                >
                                                    <svg class="h-4 w-4 mr-1.5" fill="currentColor" viewBox="0 0 20 20">
                                                        <path d="M9 9a2 2 0 114 0 2 2 0 01-4 0z" />
                                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-13a4 4 0 00-3.446 6.032l-2.261 2.26a1 1 0 101.414 1.415l2.261-2.261A4 4 0 1011 5z" clip-rule="evenodd" />
                                                    </svg>
                                                    View Details
                                                </a>
                                                <a href="{{ $song->song_url }}" 
                                                    target="_blank"
                                                    class="inline-flex items-center px-3 py-1.5 border border-gray-300 text-sm leading-5 font-medium rounded-md text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 hover:text-gray-500 dark:hover:text-white focus:outline-none focus:shadow-outline-blue active:text-gray-800 active:bg-gray-50 transition-colors"
                                                >
                                                    <svg class="h-4 w-4 mr-1.5" fill="currentColor" viewBox="0 0 20 20">
                                                        <path d="M11 3a1 1 0 100 2h2.586l-6.293 6.293a1 1 0 101.414 1.414L15 6.414V9a1 1 0 102 0V4a1 1 0 00-1-1h-5z"/>
                                                        <path d="M5 5a2 2 0 00-2 2v8a2 2 0 002 2h8a2 2 0 002-2v-3a1 1 0 10-2 0v3H5V7h3a1 1 0 000-2H5z"/>
                                                    </svg>
                                                    View on Last.fm
                                                </a>
                                                <form action="{{ route('playlists.removeSong', ['playlist' => $playlist->id, 'song' => $song->id]) }}" method="POST" class="inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" 
                                                        class="inline-flex items-center px-3 py-1.5 border border-red-500 text-sm leading-5 font-medium rounded-md text-red-500 bg-white dark:bg-gray-800 hover:text-white hover:bg-red-500 focus:outline-none focus:shadow-outline-red active:bg-red-600 transition-colors"
                                                        onclick="return confirm('Are you sure you want to remove this song from the playlist?')"
                                                    >
                                                        <svg class="h-4 w-4 mr-1.5" fill="currentColor" viewBox="0 0 20 20">
                                                            <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                                                        </svg>
                                                        Remove
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
