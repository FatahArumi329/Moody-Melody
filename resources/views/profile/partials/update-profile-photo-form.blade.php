<section class="space-y-6">
    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ __('Foto Profil') }}
        </h2>
        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __('Perbarui foto profil akun Anda.') }}
        </p>
    </header>

    <div class="flex flex-col items-center">
        <!-- Form Upload dengan AJAX -->
        <form id="profilePhotoForm" class="flex flex-col items-center space-y-4">
            @csrf
            @method('patch')
            
            <div class="relative group">
                <!-- Hidden File Input -->
                <input type="file" 
                       name="profile_photo" 
                       id="profile_photo"
                       accept="image/*"
                       class="hidden">
                
                <!-- Clickable Profile Photo Area -->
                <div class="relative cursor-pointer" onclick="document.getElementById('profile_photo').click()">
                    <!-- Current Photo or Default Avatar -->
                    <div class="w-40 h-40 rounded-full overflow-hidden border-4 border-[#D2601A] transition-all duration-300 group-hover:border-opacity-70">
                        <img src="{{ auth()->user()->profile_photo_url }}" 
                             alt="Profile Photo" 
                             class="w-full h-full object-cover transition-all duration-300 group-hover:opacity-75"
                             id="currentProfilePhoto">
                    </div>

                    <!-- Hover Overlay with Camera Icon -->
                    <div class="absolute inset-0 flex items-center justify-center rounded-full bg-black bg-opacity-50 opacity-0 group-hover:opacity-100 transition-all duration-300">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                    </div>
                </div>

                <!-- Helper Text -->
                <p class="mt-2 text-sm text-center text-gray-500 dark:text-gray-400">
                    Klik foto untuk mengganti
                </p>
            </div>

            <!-- Save Button -->
            <x-primary-button type="submit" class="mt-4" id="savePhotoButton">
                {{ __('Simpan Foto') }}
            </x-primary-button>
        </form>

        <!-- Status Messages -->
        <div id="statusMessage" class="mt-4 text-sm hidden"></div>
    </div>

    <!-- Scripts -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('profilePhotoForm');
            const fileInput = document.getElementById('profile_photo');
            const currentPhoto = document.getElementById('currentProfilePhoto');
            const statusMessage = document.getElementById('statusMessage');
            const saveButton = document.getElementById('savePhotoButton');

            // Preview foto yang dipilih
            fileInput.addEventListener('change', function() {
                if (this.files && this.files[0]) {
                    const reader = new FileReader();
                    
                    reader.onload = function(e) {
                        currentPhoto.src = e.target.result;
                    }
                    
                    reader.readAsDataURL(this.files[0]);
                }
            });

            // Handle form submission dengan AJAX
            form.addEventListener('submit', async function(e) {
                e.preventDefault();
                
                // Disable button dan tampilkan loading state
                saveButton.disabled = true;
                saveButton.innerHTML = `<svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>`;

                try {
                    const formData = new FormData(form);
                    const response = await fetch('{{ route('profile.photo.update') }}', {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        }
                    });

                    const result = await response.json();

                    // Tampilkan pesan status
                    statusMessage.classList.remove('hidden', 'text-red-600', 'text-green-600');
                    statusMessage.classList.add(result.status === 'success' ? 'text-green-600' : 'text-red-600');
                    statusMessage.textContent = result.message;

                    // Update foto jika berhasil
                    if (result.status === 'success' && result.photo_url) {
                        currentPhoto.src = result.photo_url;
                    }

                    // Sembunyikan pesan setelah beberapa detik
                    setTimeout(() => {
                        statusMessage.classList.add('hidden');
                    }, 3000);

                } catch (error) {
                    statusMessage.classList.remove('hidden', 'text-green-600');
                    statusMessage.classList.add('text-red-600');
                    statusMessage.textContent = 'Terjadi kesalahan. Silakan coba lagi.';
                }

                // Reset button state
                saveButton.disabled = false;
                saveButton.innerHTML = '{{ __('Simpan Foto') }}';
            });
        });
    </script>
</section>