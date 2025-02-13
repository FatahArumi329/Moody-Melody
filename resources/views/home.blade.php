<x-app-layout>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h1 class="text-4xl font-bold mb-4">Welcome to Moody Melody</h1>
            <p class="text-xl text-gray-600 dark:text-gray-300">Discover music that matches your mood</p>
        </div>

        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @foreach($moods as $mood)
            <div class="mood-card" 
                 x-data="{ hover: false }"
                 @mouseenter="hover = true"
                 @mouseleave="hover = false">
                <a href="{{ route('mood.songs', $mood) }}" 
                   class="block p-6 rounded-xl bg-white dark:bg-gray-800 shadow-lg transform transition-all duration-300"
                   :class="{ 'scale-105': hover }">
                    <div class="text-center">
                        <div class="w-16 h-16 mx-auto mb-4 rounded-full bg-orange-100 dark:bg-orange-900 flex items-center justify-center">
                            <span class="text-2xl">{{ $mood->emoji }}</span>
                        </div>
                        <h3 class="text-xl font-semibold mb-2">{{ $mood->name }}</h3>
                        <p class="text-gray-600 dark:text-gray-300 text-sm">{{ $mood->description }}</p>
                    </div>
                </a>
            </div>
            @endforeach
        </div>
    </div>
</x-app-layout>
