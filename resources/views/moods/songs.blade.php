<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Songs for') }} "{{ $mood }}" {{ __('Mood') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
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

                @if($songs->isEmpty())
                    <div class="p-6 text-center">
                        <p class="text-gray-500 dark:text-gray-400 text-lg">No songs found for this mood.</p>
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
                                @foreach($songs as $song)
                                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors duration-200">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <div class="ml-4">
                                                    <div class="text-sm font-medium text-gray-900 dark:text-white">
                                                        {{ $song['title'] }}
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900 dark:text-white">
                                                {{ $song['artist'] }}
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium space-x-3">
                                            <button 
                                                onclick="openAddToPlaylistModal('{{ addslashes($song['title']) }}', '{{ addslashes($song['artist']) }}', '{{ $song['url'] }}')"
                                                class="inline-flex items-center px-3 py-1.5 border border-[#D2601A] text-sm leading-5 font-medium rounded-md text-[#D2601A] bg-white dark:bg-gray-800 hover:text-white hover:bg-[#D2601A] focus:outline-none focus:shadow-outline-orange active:bg-[#b24914] transition-colors"
                                            >
                                                <svg class="h-4 w-4 mr-1.5" fill="currentColor" viewBox="0 0 20 20">
                                                    <path d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-11a1 1 0 10-2 0v2H7a1 1 0 100 2h2v2a1 1 0 102 0v-2h2a1 1 0 100-2h-2V7z"/>
                                                </svg>
                                                Add to Playlist
                                            </button>
                                            <button 
                                                onclick="openSongDetailsModal('{{ addslashes($song['title']) }}', '{{ addslashes($song['artist']) }}', '{{ $song['url'] }}')"
                                                class="inline-flex items-center px-3 py-1.5 border border-indigo-500 text-sm leading-5 font-medium rounded-md text-indigo-500 bg-white dark:bg-gray-800 hover:text-white hover:bg-indigo-500 focus:outline-none focus:shadow-outline-indigo active:bg-indigo-600 transition-colors"
                                            >
                                                <svg class="h-4 w-4 mr-1.5" fill="currentColor" viewBox="0 0 20 20">
                                                    <path d="M9 9a2 2 0 114 0 2 2 0 01-4 0z" />
                                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-13a4 4 0 00-3.446 6.032l-2.261 2.26a1 1 0 101.414 1.415l2.261-2.261A4 4 0 1011 5z" clip-rule="evenodd" />
                                                </svg>
                                                View Details
                                            </button>
                                            <a 
                                                href="{{ $song['url'] }}" 
                                                target="_blank"
                                                class="inline-flex items-center px-3 py-1.5 border border-gray-300 text-sm leading-5 font-medium rounded-md text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 hover:text-gray-500 dark:hover:text-white focus:outline-none focus:shadow-outline-blue active:text-gray-800 active:bg-gray-50 transition-colors"
                                            >
                                                <svg class="h-4 w-4 mr-1.5" fill="currentColor" viewBox="0 0 20 20">
                                                    <path d="M11 3a1 1 0 100 2h2.586l-6.293 6.293a1 1 0 101.414 1.414L15 6.414V9a1 1 0 102 0V4a1 1 0 00-1-1h-5z"/>
                                                    <path d="M5 5a2 2 0 00-2 2v8a2 2 0 002 2h8a2 2 0 002-2v-3a1 1 0 10-2 0v3H5V7h3a1 1 0 000-2H5z"/>
                                                </svg>
                                                View on Last.fm
                                            </a>
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

    <!-- Add to Playlist Modal -->
    <div id="addToPlaylistModal" class="fixed inset-0 bg-gray-500/75 dark:bg-gray-900/75 backdrop-blur-sm hidden overflow-y-auto h-full w-full flex items-center justify-center" style="z-index: 50;">
        <div class="relative mx-auto p-6 w-full max-w-7xl transform transition-all" style="width: calc(100% - 4rem);">
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl overflow-hidden">
                <div class="p-6">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-xl font-semibold text-gray-900 dark:text-gray-100">Add to Playlist</h3>
                        <button type="button" onclick="closeAddToPlaylistModal()" class="text-gray-400 hover:text-gray-500 dark:hover:text-gray-300">
                            <span class="sr-only">Close</span>
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>

                    <form id="addToPlaylistForm" action="{{ route('playlists.add-song') }}" method="POST">
                        @csrf
                        <input type="hidden" id="songTitle" name="title">
                        <input type="hidden" id="songArtist" name="artist">
                        <input type="hidden" id="songUrl" name="url">
                        
                        <div class="space-y-4">
                            <label class="text-sm font-medium text-gray-700 dark:text-gray-300">Select Playlist</label>
                            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 max-h-[60vh] overflow-y-auto pr-2">
                                @foreach(Auth::user()->playlists as $playlist)
                                    <div class="group relative flex items-center justify-between p-4 rounded-xl border border-gray-200 dark:border-gray-700 hover:border-[#D2601A] dark:hover:border-[#D2601A] transition-all duration-200">
                                        <button type="submit" name="playlist_id" value="{{ $playlist->id }}" 
                                            class="flex-grow text-left text-gray-700 dark:text-gray-300 group-hover:text-[#D2601A] dark:group-hover:text-[#D2601A] transition-colors">
                                            {{ $playlist->name }}
                                        </button>
                                        <a href="{{ route('playlists.show', $playlist->id) }}" 
                                            class="ml-3 text-gray-400 hover:text-[#D2601A] dark:hover:text-[#D2601A] transition-colors">
                                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            </svg>
                                        </a>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <div class="mt-6 flex justify-end gap-3">
                            <button type="button" onclick="closeAddToPlaylistModal()" 
                                    class="px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 rounded-xl transition-colors">
                                Cancel
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Song Details Modal -->
    <div id="songDetailsModal" class="fixed inset-0 bg-gray-500/75 dark:bg-gray-900/75 backdrop-blur-sm hidden overflow-y-auto h-full w-full flex items-center justify-center" style="z-index: 50;">
        <div class="relative mx-auto p-6 w-full max-w-7xl transform transition-all" style="width: calc(100% - 4rem);">
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl overflow-hidden">
                <div class="p-6">
                    <div class="flex items-center justify-between mb-6">
                        <div>
                            <h1 class="text-3xl font-bold text-gray-900 dark:text-gray-100" id="detailsSongTitle"></h1>
                            <p class="text-xl text-gray-600 dark:text-gray-400" id="detailsSongArtist"></p>
                        </div>
                        <div class="flex items-center gap-3">
                            <button type="button" onclick="closeSongDetailsModal()" class="text-gray-400 hover:text-gray-500 dark:hover:text-gray-300">
                                <span class="sr-only">Close</span>
                                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="bg-gray-50 dark:bg-gray-700 p-6 rounded-xl">
                            <h3 class="text-lg font-semibold mb-4 text-gray-900 dark:text-gray-100">Song Information</h3>
                            <div class="space-y-3">
                                <div>
                                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Title</p>
                                    <p class="mt-1 text-gray-900 dark:text-gray-100" id="detailsSongTitleInfo"></p>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Artist</p>
                                    <p class="mt-1 text-gray-900 dark:text-gray-100" id="detailsSongArtistInfo"></p>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Mood Category</p>
                                    <p class="mt-1 text-gray-900 dark:text-gray-100">{{ ucfirst($mood) }}</p>
                                </div>
                            </div>
                        </div>

                        <div class="bg-gray-50 dark:bg-gray-700 p-6 rounded-xl">
                            <h3 class="text-lg font-semibold mb-4 text-gray-900 dark:text-gray-100">Actions</h3>
                            <div class="space-y-4">
                                <button onclick="openAddToPlaylistModal(currentSongTitle, currentSongArtist, currentSongUrl); closeSongDetailsModal();" 
                                    class="w-full bg-[#D2601A] hover:bg-[#b24914] text-white font-bold py-3 px-4 rounded-lg transition-colors inline-flex items-center justify-center">
                                    <svg class="h-5 w-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-11a1 1 0 10-2 0v2H7a1 1 0 100 2h2v2a1 1 0 102 0v-2h2a1 1 0 100-2h-2V7z"/>
                                    </svg>
                                    Add to Playlist
                                </button>
                                
                                <a id="detailsSongUrl" href="#" target="_blank" 
                                    class="w-full bg-[#d51007] hover:bg-[#b30d06] text-white font-bold py-3 px-4 rounded-lg transition-colors inline-flex items-center justify-center">
                                    <svg class="h-5 w-5 mr-2" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M10.042 11.27c0 1.9-1.544 3.445-3.445 3.445-1.9 0-3.445-1.544-3.445-3.445 0-1.9 1.544-3.445 3.445-3.445 1.9 0 3.445 1.544 3.445 3.445zm4.723 2.021v-4.041h1.36v4.041h-1.36zm5.276 0v-4.041h1.36v4.041h-1.36z"/>
                                    </svg>
                                    View on Last.fm
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        function openAddToPlaylistModal(title, artist, url) {
            document.getElementById('songTitle').value = title;
            document.getElementById('songArtist').value = artist;
            document.getElementById('songUrl').value = url;
            document.getElementById('addToPlaylistModal').classList.remove('hidden');
            document.body.classList.add('overflow-hidden');
        }

        function closeAddToPlaylistModal() {
            document.getElementById('addToPlaylistModal').classList.add('hidden');
            document.body.classList.remove('overflow-hidden');
            document.getElementById('addToPlaylistForm').reset();
        }

        let currentSongTitle = '';
        let currentSongArtist = '';
        let currentSongUrl = '';

        function openSongDetailsModal(title, artist, url) {
            currentSongTitle = title;
            currentSongArtist = artist;
            currentSongUrl = url;
            
            document.getElementById('detailsSongTitle').textContent = title;
            document.getElementById('detailsSongArtist').textContent = artist;
            document.getElementById('detailsSongTitleInfo').textContent = title;
            document.getElementById('detailsSongArtistInfo').textContent = artist;
            document.getElementById('detailsSongUrl').href = url;
            
            document.getElementById('songDetailsModal').classList.remove('hidden');
            document.body.classList.add('overflow-hidden');
        }

        function closeSongDetailsModal() {
            document.getElementById('songDetailsModal').classList.add('hidden');
            document.body.classList.remove('overflow-hidden');
        }

        // Close modal when clicking outside
        window.onclick = function(event) {
            var detailsModal = document.getElementById('songDetailsModal');
            var playlistModal = document.getElementById('addToPlaylistModal');
            
            if (event.target == detailsModal) {
                closeSongDetailsModal();
            } else if (event.target == playlistModal) {
                closeAddToPlaylistModal();
            }
        }
    </script>
    @endpush
</x-app-layout>
