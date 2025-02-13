<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Mood') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach($moods as $key => $mood)
                            <a href="{{ route('moods.songs', $key) }}" 
                               class="bg-gray-50 dark:bg-gray-700 rounded-lg p-6 hover:shadow-lg transition flex items-center gap-4">
                                <!-- Icon untuk setiap mood -->
                                <div class="w-12 h-12 flex items-center justify-center rounded-full 
                                    @if($key === 'happy') bg-yellow-100 text-yellow-600
                                    @elseif($key === 'sad') bg-blue-100 text-blue-600
                                    @elseif($key === 'energetic') bg-red-100 text-red-600
                                    @elseif($key === 'relaxed') bg-green-100 text-green-600
                                    @elseif($key === 'romantic') bg-pink-100 text-pink-600
                                    @else bg-purple-100 text-purple-600
                                    @endif">
                                    @if($key === 'happy')
                                        <svg class="w-6 h-6" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M12 22C17.5228 22 22 17.5228 22 12C22 6.47715 17.5228 2 12 2C6.47715 2 2 6.47715 2 12C2 17.5228 6.47715 22 12 22Z" stroke="currentColor" stroke-width="2"/>
                                            <path d="M8 14C8 14 9.5 16 12 16C14.5 16 16 14 16 14" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                                            <path d="M9 9H9.01" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                                            <path d="M15 9H15.01" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                                        </svg>
                                    @elseif($key === 'sad')
                                        <svg class="w-6 h-6" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M12 22C17.5228 22 22 17.5228 22 12C22 6.47715 17.5228 2 12 2C6.47715 2 2 6.47715 2 12C2 17.5228 6.47715 22 12 22Z" stroke="currentColor" stroke-width="2"/>
                                            <path d="M8 16C8 16 9.5 14 12 14C14.5 14 16 16 16 16" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                                            <path d="M9 9H9.01" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                                            <path d="M15 9H15.01" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                                        </svg>
                                    @elseif($key === 'energetic')
                                        <svg class="w-6 h-6" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M13 2L3 14H12L11 22L21 10H12L13 2Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                        </svg>
                                    @elseif($key === 'relaxed')
                                        <svg class="w-6 h-6" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M12 22C17.5228 22 22 17.5228 22 12C22 6.47715 17.5228 2 12 2C6.47715 2 2 6.47715 2 12C2 17.5228 6.47715 22 12 22Z" stroke="currentColor" stroke-width="2"/>
                                            <path d="M7 14H17" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                                            <path d="M9 9H9.01" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                                            <path d="M15 9H15.01" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                                        </svg>
                                    @elseif($key === 'romantic')
                                        <svg class="w-6 h-6" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z" stroke="currentColor" stroke-width="2"/>
                                        </svg>
                                    @else
                                        <svg class="w-6 h-6" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M12 22C17.5228 22 22 17.5228 22 12C22 6.47715 17.5228 2 12 2C6.47715 2 2 6.47715 2 12C2 17.5228 6.47715 22 12 22Z" stroke="currentColor" stroke-width="2"/>
                                            <path d="M12 16V17" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                                            <path d="M12 7V14" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                                        </svg>
                                    @endif
                                </div>

                                <div>
                                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">{{ $mood }}</h3>
                                    <p class="text-sm text-gray-600 dark:text-gray-400">Temukan lagu sesuai mood Anda</p>
                                </div>
                            </a>
                        @endforeach

                        <!-- Custom Mood -->
                        <a href="{{ route('moods.custom') }}" 
                           class="bg-gradient-to-r from-[#D2601A] to-[#e67a3c] rounded-lg p-6 hover:shadow-lg transition flex items-center gap-4">
                            <div class="w-12 h-12 flex items-center justify-center rounded-full bg-white/20">
                                <svg class="w-6 h-6 text-white" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M12 5V19" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                                    <path d="M5 12H19" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-lg font-semibold text-white">Custom Mood</h3>
                                <p class="text-sm text-white/80">Buat mood Anda sendiri</p>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
