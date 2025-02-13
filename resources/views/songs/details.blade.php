<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Song Details
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="mb-8">
                        <div class="flex items-center justify-between mb-6">
                            <div>
                                <h1 class="text-3xl font-bold mb-2">{{ $song->title }}</h1>
                                <p class="text-xl text-gray-600 dark:text-gray-400">{{ $song->artist }}</p>
                            </div>
                            <div class="flex gap-3">
                                @if($trackInfo && isset($trackInfo['url']))
                                    <a href="{{ $trackInfo['url'] }}" target="_blank" 
                                       class="bg-[#d51007] hover:bg-[#b30d06] text-white font-bold py-2 px-4 rounded inline-flex items-center">
                                        <i class="fas fa-lastfm mr-2"></i> View on Last.fm
                                    </a>
                                @endif
                                <a href="{{ $song->song_url }}" target="_blank" 
                                   class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded inline-flex items-center">
                                    <i class="fas fa-play mr-2"></i> Play Song
                                </a>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            @if($trackInfo)
                                <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                                    <h3 class="text-lg font-semibold mb-3">Song Information</h3>
                                    <div class="space-y-2">
                                        <p><span class="font-medium">Title:</span> {{ $trackInfo['name'] ?? $song->title }}</p>
                                        <p><span class="font-medium">Artist:</span> {{ $trackInfo['artist']['name'] ?? $song->artist }}</p>
                                        @if(isset($trackInfo['album']))
                                            <p><span class="font-medium">Album:</span> {{ $trackInfo['album']['title'] }}</p>
                                        @endif
                                        @if(isset($trackInfo['duration']))
                                            <p><span class="font-medium">Duration:</span> {{ gmdate("i:s", $trackInfo['duration']/1000) }}</p>
                                        @endif
                                        @if(isset($trackInfo['listeners']))
                                            <p><span class="font-medium">Listeners:</span> {{ number_format($trackInfo['listeners']) }}</p>
                                        @endif
                                        @if(isset($trackInfo['playcount']))
                                            <p><span class="font-medium">Play Count:</span> {{ number_format($trackInfo['playcount']) }}</p>
                                        @endif
                                    </div>
                                </div>

                                @if(isset($trackInfo['wiki']))
                                    <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                                        <h3 class="text-lg font-semibold mb-3">About the Song</h3>
                                        <div class="prose dark:prose-invert max-w-none">
                                            <p class="text-sm">{{ Str::limit($trackInfo['wiki']['summary'] ?? '', 300) }}</p>
                                            @if(isset($trackInfo['wiki']['content']))
                                                <a href="#" onclick="toggleContent(event)" class="text-blue-500 hover:text-blue-600 text-sm">Read more</a>
                                                <div id="full-content" class="hidden mt-2">
                                                    <p class="text-sm">{{ $trackInfo['wiki']['content'] }}</p>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                @endif

                                @if(isset($trackInfo['toptags']['tag']))
                                    <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                                        <h3 class="text-lg font-semibold mb-3">Tags</h3>
                                        <div class="flex flex-wrap gap-2">
                                            @foreach($trackInfo['toptags']['tag'] as $tag)
                                                <span class="px-3 py-1 bg-gray-200 dark:bg-gray-600 rounded-full text-sm">
                                                    {{ $tag['name'] }}
                                                </span>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif
                            @else
                                <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                                    <h3 class="text-lg font-semibold mb-3">Song Information</h3>
                                    <div class="space-y-2">
                                        <p><span class="font-medium">Title:</span> {{ $song->title }}</p>
                                        <p><span class="font-medium">Artist:</span> {{ $song->artist }}</p>
                                        <p><span class="font-medium">URL:</span> 
                                            <a href="{{ $song->song_url }}" target="_blank" class="text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300">
                                                {{ $song->song_url }}
                                            </a>
                                        </p>
                                    </div>
                                </div>
                            @endif

                            <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                                <h3 class="text-lg font-semibold mb-3">Actions</h3>
                                <div>
                                    <a href="{{ url()->previous() }}" class="w-full bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded inline-block text-center">
                                        <i class="fas fa-arrow-left mr-2"></i> Back
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function toggleContent(event) {
            event.preventDefault();
            const fullContent = document.getElementById('full-content');
            fullContent.classList.toggle('hidden');
            event.target.textContent = fullContent.classList.contains('hidden') ? 'Read more' : 'Read less';
        }
    </script>
</x-app-layout>
