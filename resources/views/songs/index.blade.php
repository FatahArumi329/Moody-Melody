{{-- <x-app-layout>
    <form method="GET" action="{{ route('songs.index') }}">
        <input type="text" name="search" placeholder="Cari judul atau artis..." class="px-4 py-2 border rounded-lg">
        <button type="submit" class="px-4 py-2 bg-[#D2601A] text-white rounded-lg">Cari</button>
    </form>

    @if($search)
        <p>Hasil pencarian untuk: <strong>{{ $search }}</strong></p>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($songs as $song)
            <div class="bg-white rounded-lg shadow-lg p-6">
                <h4>{{ $song->title ?? 'Unknown Title' }}</h4>
                <p>{{ $song->artist ?? 'Unknown Artist' }}</p>
            </div>
        @empty
            <p>Tidak ada lagu yang ditemukan.</p>
        @endforelse
    </div>
</x-app-layout> --}}
{{-- <x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            Songs for {{ ucfirst($mood) }} Mood
        </h2>
    </x-slot>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <!-- Input Pencarian -->
        <div class="text-center mb-8">
            <input 
                type="text" 
                id="searchInput" 
                placeholder="Search songs or artists..." 
                class="border-gray-300 dark:border-gray-700 rounded-lg p-2 w-3/4 focus:ring-[#D2601A] focus:border-[#D2601A]"
            >
        </div>

        <!-- Hasil Pencarian -->
        <div id="songsContainer" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach ($songs as $song)
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6 flex flex-col items-center">
                    <h4 class="text-lg font-semibold text-[#D2601A] dark:text-white mb-2 text-center">
                        {{ $song->title ?? 'Unknown Title' }}
                    </h4>
                    <p class="text-sm text-gray-600 dark:text-gray-300 mb-4 text-center">
                        {{ $song->artist ?? 'Unknown Artist' }}
                    </p>

                    <audio src="{{ $song->url }}" controls class="w-full"></audio>
                </div>
            @endforeach
        </div>
    </div>

    @push('scripts')
        <script>
            document.getElementById('searchInput').addEventListener('input', function () {
                const query = this.value;

                // AJAX request to search songs
                fetch(`{{ route('songs.search') }}?query=${query}`)
                    .then(response => response.json())
                    .then(songs => {
                        const container = document.getElementById('songsContainer');
                        container.innerHTML = ''; // Clear existing songs

                        if (songs.length > 0) {
                            // Render each song
                            songs.forEach(song => {
                                const songElement = `
                                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6 flex flex-col items-center">
                                        <h4 class="text-lg font-semibold text-[#D2601A] dark:text-white mb-2 text-center">
                                            ${song.title || 'Unknown Title'}
                                        </h4>
                                        <p class="text-sm text-gray-600 dark:text-gray-300 mb-4 text-center">
                                            ${song.artist || 'Unknown Artist'}
                                        </p>
                                        <audio src="${song.url}" controls class="w-full"></audio>
                                    </div>
                                `;
                                container.innerHTML += songElement;
                            });
                        } else {
                            // Display no results message
                            container.innerHTML = `
                                <div class="col-span-full text-center">
                                    <p class="text-lg text-gray-500">No songs found for "${query}".</p>
                                </div>
                            `;
                        }
                    });
            });
        </script>
    @endpush
</x-app-layout> --}}
{{-- <x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            Songs for {{ ucfirst($mood) }} Mood
        </h2>
    </x-slot>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <!-- Input Pencarian -->
        <div class="text-center mb-8">
            <input 
                type="text" 
                id="searchInput" 
                placeholder="Search songs or artists..." 
                class="border-gray-300 dark:border-gray-700 rounded-lg p-2 w-3/4 focus:ring-[#D2601A] focus:border-[#D2601A]"
            >
        </div>

        <!-- Hasil Pencarian -->
        <div id="songsContainer" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach ($songs as $song)
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6 flex flex-col items-center">
                    <h4 class="text-lg font-semibold text-[#D2601A] dark:text-white mb-2 text-center">
                        {{ $song['title'] ?? 'Unknown Title' }}
                    </h4>
                    <p class="text-sm text-gray-600 dark:text-gray-300 mb-4 text-center">
                        {{ $song['artist'] ?? 'Unknown Artist' }}
                    </p>

                    <audio src="{{ $song['url'] }}" controls class="w-full"></audio>
                </div>
            @endforeach
        </div>
    </div>

    @push('scripts')
        <script>
            document.getElementById('searchInput').addEventListener('input', function () {
                const query = this.value;

                // Jika query kosong, tidak melakukan pencarian
                if (query.trim() === "") {
                    return;
                }

                // AJAX request untuk mencari lagu
                fetch(`{{ route('songs.search') }}?query=${query}`)
                    .then(response => response.json())
                    .then(songs => {
                        const container = document.getElementById('songsContainer');
                        container.innerHTML = ''; // Bersihkan hasil pencarian yang lama

                        if (songs.length > 0) {
                            // Render setiap lagu
                            songs.forEach(song => {
                                const songElement = `
                                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6 flex flex-col items-center">
                                        <h4 class="text-lg font-semibold text-[#D2601A] dark:text-white mb-2 text-center">
                                            ${song.title || 'Unknown Title'}
                                        </h4>
                                        <p class="text-sm text-gray-600 dark:text-gray-300 mb-4 text-center">
                                            ${song.artist || 'Unknown Artist'}
                                        </p>
                                        <audio src="${song.url}" controls class="w-full"></audio>
                                    </div>
                                `;
                                container.innerHTML += songElement;
                            });
                        } else {
                            // Menampilkan pesan jika tidak ada lagu yang ditemukan
                            container.innerHTML = `
                                <div class="col-span-full text-center">
                                    <p class="text-lg text-gray-500">No songs found for "${query}".</p>
                                </div>
                            `;
                        }
                    });
            });
        </script>
    @endpush
</x-app-layout> --}}
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            Songs for {{ ucfirst($mood) }} Mood
        </h2>
    </x-slot>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <!-- Input Pencarian -->
        <div class="text-center mb-8">
            <input 
                type="text" 
                id="searchInput" 
                placeholder="Search songs or artists..." 
                class="border-gray-300 dark:border-gray-700 rounded-lg p-2 w-3/4 focus:ring-[#D2601A] focus:border-[#D2601A]"
            >
        </div>

        <!-- Hasil Pencarian -->
        <div id="songsContainer" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach ($songs as $song)
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6 flex flex-col items-center">
                    <h4 class="text-lg font-semibold text-[#D2601A] dark:text-white mb-2 text-center">
                        {{ $song['title'] ?? 'Unknown Title' }}
                    </h4>
                    <p class="text-sm text-gray-600 dark:text-gray-300 mb-4 text-center">
                        {{ $song['artist'] ?? 'Unknown Artist' }}
                    </p>

                    <audio src="{{ $song['url'] }}" controls class="w-full"></audio>
                </div>
            @endforeach
        </div>
    </div>

    @push('scripts')
        <script>
            document.getElementById('searchInput').addEventListener('input', function () {
    const query = this.value;
    const currentUrl = window.location.href.split('?')[0]; // Ambil URL saat ini tanpa query string

    if (query.trim() === "") {
        return;
    }

    // Membentuk URL pencarian dengan query
    const searchUrl = `${currentUrl}?search=${query}`;

    fetch(searchUrl)
        .then(response => response.json())
        .then(songs => {
            const container = document.getElementById('songsContainer');
            container.innerHTML = ''; // Bersihkan hasil pencarian yang lama

            if (songs.length > 0) {
                songs.forEach(song => {
                    const songElement = `
                        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6 flex flex-col items-center">
                            <h4 class="text-lg font-semibold text-[#D2601A] dark:text-white mb-2 text-center">
                                ${song.name || 'Unknown Title'}
                            </h4>
                            <p class="text-sm text-gray-600 dark:text-gray-300 mb-4 text-center">
                                ${song.artist || 'Unknown Artist'}
                            </p>
                            <audio src="${song.url}" controls class="w-full"></audio>
                        </div>
                    `;
                    container.innerHTML += songElement;
                });
            } else {
                container.innerHTML = `
                    <div class="col-span-full text-center">
                        <p class="text-lg text-gray-500">No songs found for "${query}".</p>
                    </div>
                `;
            }
        });
});

//             document.getElementById('searchInput').addEventListener('input', function () {
//     const query = this.value;
//     const currentUrl = window.location.href.split('?')[0]; // Ambil URL saat ini tanpa query string

//     if (query.trim() === "") {
//         return;
//     }

//     // Membentuk URL pencarian dengan query
//     const searchUrl = `${currentUrl}?search=${query}`;

//     fetch(searchUrl)
//         .then(response => response.json())
//         .then(songs => {
//             const container = document.getElementById('songsContainer');
//             container.innerHTML = ''; // Bersihkan hasil pencarian yang lama

//             if (songs.length > 0) {
//                 songs.forEach(song => {
//                     const songElement = `
//                         <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6 flex flex-col items-center">
//                             <h4 class="text-lg font-semibold text-[#D2601A] dark:text-white mb-2 text-center">
//                                 ${song.title || 'Unknown Title'}
//                             </h4>
//                             <p class="text-sm text-gray-600 dark:text-gray-300 mb-4 text-center">
//                                 ${song.artist || 'Unknown Artist'}
//                             </p>
//                             <audio src="${song.url}" controls class="w-full"></audio>
//                         </div>
//                     `;
//                     container.innerHTML += songElement;
//                 });
//             } else {
//                 container.innerHTML = `
//                     <div class="col-span-full text-center">
//                         <p class="text-lg text-gray-500">No songs found for "${query}".</p>
//                     </div>
//                 `;
//             }
//         });
// });

        </script>
    @endpush
</x-app-layout>
