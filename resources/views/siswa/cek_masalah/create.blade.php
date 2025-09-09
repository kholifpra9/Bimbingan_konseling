<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Formulir Daftar Cek Masalah') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    
                    <!-- Header -->
                    <div class="mb-6">
                        <h3 class="text-lg font-semibold mb-2">Identifikasi Masalah Pribadi</h3>
                        <p class="text-gray-600 dark:text-gray-400">
                            Silakan isi formulir ini untuk membantu kami memahami masalah yang Anda hadapi. 
                            Informasi ini akan membantu Guru BK memberikan bimbingan yang tepat.
                        </p>
                    </div>

                    @if(session('success'))
                        <div class="mb-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                            <strong class="font-bold">Berhasil!</strong>
                            <span class="block sm:inline">{{ session('success') }}</span>
                        </div>
                    @endif

                    <!-- Form Daftar Cek Masalah -->
                    <form action="{{ route('siswa.cek-masalah.store') }}" method="POST" class="space-y-6">
                        @csrf

                        <!-- Kategori Masalah -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            @foreach($daftarMasalah as $kategori => $masalahList)
                                <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg border-2 kategori-card" data-kategori="{{ $kategori }}">
                                    <h4 class="text-lg font-semibold mb-3 text-{{ $kategori == 'pribadi' ? 'purple' : ($kategori == 'sosial' ? 'green' : ($kategori == 'belajar' ? 'blue' : 'orange')) }}-600">
                                        <i class="fas fa-{{ $kategori == 'pribadi' ? 'heart' : ($kategori == 'sosial' ? 'users' : ($kategori == 'belajar' ? 'book' : 'briefcase')) }} mr-2"></i>
                                        {{ ucfirst($kategori) }}
                                    </h4>
                                    
                                    <div class="space-y-2">
                                        @foreach($masalahList as $masalah)
                                            <label class="flex items-center">
                                                <input type="checkbox" name="masalah_terpilih[]" value="{{ $masalah }}"
                                                       class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 masalah-checkbox"
                                                       data-kategori="{{ $kategori }}"
                                                       {{ in_array($masalah, old('masalah_terpilih', [])) ? 'checked' : '' }}>
                                                <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">{{ $masalah }}</span>
                                            </label>
                                        @endforeach
                                    </div>

                                    <!-- Hidden checkbox untuk kategori (multiple selection) -->
                                    <input type="checkbox" name="kategori_masalah[]" value="{{ $kategori }}" 
                                           class="hidden kategori-checkbox" id="kategori_{{ $kategori }}"
                                           {{ in_array($kategori, old('kategori_masalah', [])) ? 'checked' : '' }}>
                                </div>
                            @endforeach
                        </div>

                        @error('masalah_terpilih')
                            <p class="text-sm text-red-600">{{ $message }}</p>
                        @enderror

                        @error('kategori_masalah')
                            <p class="text-sm text-red-600">{{ $message }}</p>
                        @enderror

                        <!-- Masalah Lain -->
                        <div>
                            <label for="masalah_lain" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Masalah Lain (jika ada)
                            </label>
                            <textarea name="masalah_lain" id="masalah_lain" rows="2"
                                      placeholder="Tuliskan masalah lain yang tidak tercantum di atas..."
                                      class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white">{{ old('masalah_lain') }}</textarea>
                        </div>

                        <!-- Tingkat Urgensi -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Seberapa mendesak masalah ini bagi Anda? <span class="text-red-500">*</span>
                            </label>
                            <div class="flex space-x-4">
                                <label class="flex items-center">
                                    <input type="radio" name="tingkat_urgensi" value="rendah" required
                                           class="text-green-600 focus:ring-green-500"
                                           {{ old('tingkat_urgensi') == 'rendah' ? 'checked' : '' }}>
                                    <span class="ml-2 text-sm text-green-600">Rendah - Bisa ditangani nanti</span>
                                </label>
                                <label class="flex items-center">
                                    <input type="radio" name="tingkat_urgensi" value="sedang" required
                                           class="text-yellow-600 focus:ring-yellow-500"
                                           {{ old('tingkat_urgensi') == 'sedang' ? 'checked' : '' }}>
                                    <span class="ml-2 text-sm text-yellow-600">Sedang - Perlu perhatian</span>
                                </label>
                                <label class="flex items-center">
                                    <input type="radio" name="tingkat_urgensi" value="tinggi" required
                                           class="text-red-600 focus:ring-red-500"
                                           {{ old('tingkat_urgensi') == 'tinggi' ? 'checked' : '' }}>
                                    <span class="ml-2 text-sm text-red-600">Tinggi - Sangat mengganggu</span>
                                </label>
                            </div>
                            @error('tingkat_urgensi')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Deskripsi Tambahan -->
                        <div>
                            <label for="deskripsi_tambahan" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Ceritakan lebih detail tentang masalah Anda
                            </label>
                            <textarea name="deskripsi_tambahan" id="deskripsi_tambahan" rows="4"
                                      placeholder="Jelaskan situasi yang Anda alami, kapan masalah ini mulai terjadi, dan bagaimana dampaknya terhadap Anda..."
                                      class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white">{{ old('deskripsi_tambahan') }}</textarea>
                        </div>

                        <!-- Tombol Submit -->
                        <div class="flex flex-col sm:flex-row justify-center items-center gap-6 pt-8 mt-8 border-t-2 border-gray-200 dark:border-gray-600">
                            <a href="{{ route('dashboard') }}" 
                               class="w-full sm:w-auto bg-gray-500 hover:bg-gray-700 text-white font-semibold py-4 px-8 rounded-xl shadow-lg transition duration-300 ease-in-out transform hover:scale-105 text-center">
                                <i class="fas fa-arrow-left mr-3"></i>Kembali ke Dashboard
                            </a>
                            <button type="submit" 
                                    class="w-full sm:w-auto bg-red-800 hover:bg-red-900 text-white font-semibold py-4 px-10 rounded-xl shadow-lg transition duration-300 ease-in-out transform hover:scale-105 focus:outline-none focus:ring-4 focus:ring-red-300 focus:ring-opacity-50">
                                <i class="fas fa-paper-plane mr-3"></i>Kirim Formulir
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Auto-select kategori when checkbox is checked (MULTIPLE CATEGORIES ALLOWED)
        document.addEventListener('DOMContentLoaded', function() {
            const checkboxes = document.querySelectorAll('.masalah-checkbox');
            
            checkboxes.forEach(checkbox => {
                checkbox.addEventListener('change', function() {
                    const kategori = this.dataset.kategori;
                    const kategoriCheckbox = document.getElementById('kategori_' + kategori);
                    const kategoriCard = document.querySelector(`[data-kategori="${kategori}"]`);
                    
                    // Check if any checkbox in this category is checked
                    const categoryCheckboxes = document.querySelectorAll(`input[data-kategori="${kategori}"]`);
                    const hasChecked = Array.from(categoryCheckboxes).some(cb => cb.checked);
                    
                    if (hasChecked) {
                        // Mark this category as selected
                        kategoriCheckbox.checked = true;
                        kategoriCard.classList.add('border-indigo-500', 'bg-indigo-50', 'dark:bg-indigo-900');
                    } else {
                        // Unmark this category if no problems selected
                        kategoriCheckbox.checked = false;
                        kategoriCard.classList.remove('border-indigo-500', 'bg-indigo-50', 'dark:bg-indigo-900');
                    }
                });
            });

            // Initialize on page load for old values
            checkboxes.forEach(checkbox => {
                if (checkbox.checked) {
                    const kategori = checkbox.dataset.kategori;
                    const kategoriCheckbox = document.getElementById('kategori_' + kategori);
                    const kategoriCard = document.querySelector(`[data-kategori="${kategori}"]`);
                    
                    kategoriCheckbox.checked = true;
                    kategoriCard.classList.add('border-indigo-500', 'bg-indigo-50', 'dark:bg-indigo-900');
                }
            });
        });
    </script>
</x-app-layout>
