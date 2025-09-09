<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Daftar Cek Masalah') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    
                    <!-- Header -->
                    <div class="mb-6">
                        <h3 class="text-lg font-semibold mb-2">Identifikasi Masalah Siswa</h3>
                        <p class="text-gray-600 dark:text-gray-400">
                            Gunakan daftar cek ini untuk mengidentifikasi masalah yang dihadapi siswa berdasarkan kategori.
                        </p>
                    </div>

                    <!-- Form Daftar Cek Masalah -->
                    <form action="{{ route('gurubk.daftar-cek-masalah.store') }}" method="POST" class="space-y-6">
                        @csrf

                        <!-- Pilih Siswa -->
                        <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                            <label for="id_siswa" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Pilih Siswa <span class="text-red-500">*</span>
                            </label>
                            <select name="id_siswa" id="id_siswa" required
                                    class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-600 dark:text-white">
                                <option value="">-- Pilih Siswa --</option>
                                @foreach($siswa as $s)
                                    <option value="{{ $s->id }}" {{ old('id_siswa') == $s->id ? 'selected' : '' }}>
                                        {{ $s->nama }} - {{ $s->kelas }} {{ $s->jurusan }}
                                    </option>
                                @endforeach
                            </select>
                            @error('id_siswa')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Kategori Masalah -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            @foreach($daftarMasalah as $kategori => $masalahList)
                                <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                                    <h4 class="text-lg font-semibold mb-3 text-{{ $kategori == 'akademik' ? 'blue' : ($kategori == 'sosial' ? 'green' : ($kategori == 'pribadi' ? 'purple' : 'orange')) }}-600">
                                        <i class="fas fa-{{ $kategori == 'akademik' ? 'book' : ($kategori == 'sosial' ? 'users' : ($kategori == 'pribadi' ? 'heart' : 'briefcase')) }} mr-2"></i>
                                        {{ ucfirst($kategori) }}
                                    </h4>
                                    
                                    <div class="space-y-2">
                                        @foreach($masalahList as $masalah)
                                            <label class="flex items-center">
                                                <input type="checkbox" name="masalah_terpilih[]" value="{{ $masalah }}"
                                                       class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                                       {{ in_array($masalah, old('masalah_terpilih', [])) ? 'checked' : '' }}>
                                                <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">{{ $masalah }}</span>
                                            </label>
                                        @endforeach
                                    </div>

                                    <!-- Radio button untuk kategori -->
                                    <input type="radio" name="kategori_masalah" value="{{ $kategori }}" 
                                           class="hidden kategori-radio" id="kategori_{{ $kategori }}"
                                           {{ old('kategori_masalah') == $kategori ? 'checked' : '' }}>
                                </div>
                            @endforeach
                        </div>

                        @error('masalah_terpilih')
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
                                Tingkat Urgensi <span class="text-red-500">*</span>
                            </label>
                            <div class="flex space-x-4">
                                <label class="flex items-center">
                                    <input type="radio" name="tingkat_urgensi" value="rendah" required
                                           class="text-green-600 focus:ring-green-500"
                                           {{ old('tingkat_urgensi') == 'rendah' ? 'checked' : '' }}>
                                    <span class="ml-2 text-sm text-green-600">Rendah</span>
                                </label>
                                <label class="flex items-center">
                                    <input type="radio" name="tingkat_urgensi" value="sedang" required
                                           class="text-yellow-600 focus:ring-yellow-500"
                                           {{ old('tingkat_urgensi') == 'sedang' ? 'checked' : '' }}>
                                    <span class="ml-2 text-sm text-yellow-600">Sedang</span>
                                </label>
                                <label class="flex items-center">
                                    <input type="radio" name="tingkat_urgensi" value="tinggi" required
                                           class="text-red-600 focus:ring-red-500"
                                           {{ old('tingkat_urgensi') == 'tinggi' ? 'checked' : '' }}>
                                    <span class="ml-2 text-sm text-red-600">Tinggi</span>
                                </label>
                            </div>
                            @error('tingkat_urgensi')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Catatan Guru -->
                        <div>
                            <label for="catatan_guru" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Catatan Guru BK
                            </label>
                            <textarea name="catatan_guru" id="catatan_guru" rows="3"
                                      placeholder="Tambahkan catatan atau observasi tambahan..."
                                      class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white">{{ old('catatan_guru') }}</textarea>
                        </div>

                        <!-- Tombol Submit -->
                        <div class="flex flex-col sm:flex-row justify-center items-center gap-6 pt-8 mt-8 border-t-2 border-gray-200 dark:border-gray-600">
                            <a href="{{ route('dashboard') }}" 
                               class="w-full sm:w-auto bg-gray-500 hover:bg-gray-700 text-white font-semibold py-4 px-8 rounded-xl shadow-lg transition duration-300 ease-in-out transform hover:scale-105 text-center">
                                <i class="fas fa-arrow-left mr-3"></i>Kembali ke Dashboard
                            </a>
                            @hasrole('gurubk')
                            <button type="submit" 
                                    class="w-full sm:w-auto bg-red-800 hover:bg-red-900 text-white font-semibold py-4 px-10 rounded-xl shadow-lg transition duration-300 ease-in-out transform hover:scale-105 focus:outline-none focus:ring-4 focus:ring-red-300 focus:ring-opacity-50">
                                <i class="fas fa-save mr-3"></i>Simpan Hasil Cek
                            </button>
                            @else
                            <div class="w-full sm:w-auto bg-gray-300 text-gray-600 font-semibold py-4 px-10 rounded-xl text-center">
                                <i class="fas fa-eye mr-3"></i>Hanya untuk Melihat
                            </div>
                            @endhasrole
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Auto-select kategori when checkbox is checked
        document.addEventListener('DOMContentLoaded', function() {
            const checkboxes = document.querySelectorAll('input[name="masalah_terpilih[]"]');
            
            checkboxes.forEach(checkbox => {
                checkbox.addEventListener('change', function() {
                    if (this.checked) {
                        // Find the parent kategori
                        const parentDiv = this.closest('.bg-gray-50, .dark\\:bg-gray-700');
                        const kategoriRadio = parentDiv.querySelector('.kategori-radio');
                        if (kategoriRadio) {
                            kategoriRadio.checked = true;
                        }
                    }
                });
            });
        });
    </script>
</x-app-layout>
