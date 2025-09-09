<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Tambah Pengaduan') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    
                    <!-- Header -->
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-lg font-semibold">Form Tambah Pengaduan</h3>
                        <a href="{{ route('pengaduan.index') }}" 
                           class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                            <i class="fas fa-arrow-left mr-2"></i>Kembali
                        </a>
                    </div>

                    <!-- Form -->
                    <form action="{{ route('pengaduan.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                        @csrf

                        <!-- NIS -->
                        <div>
                            <label for="nis" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                NIS <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="nis" id="nis" 
                                   value="{{ old('nis') }}" required
                                   class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white">
                            @error('nis')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Tanggal Pengaduan -->
                        <div>
                            <label for="tgl_pengaduan" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Tanggal Pengaduan <span class="text-red-500">*</span>
                            </label>
                            <input type="date" name="tgl_pengaduan" id="tgl_pengaduan" 
                                   value="{{ old('tgl_pengaduan', date('Y-m-d')) }}" required
                                   class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white">
                            @error('tgl_pengaduan')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Jenis Pengaduan -->
                        <div>
                            <label for="jenis_pengaduan" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Jenis Pengaduan <span class="text-red-500">*</span>
                            </label>
                            <select name="jenis_pengaduan" id="jenis_pengaduan" required
                                    class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white">
                                <option value="">-- Pilih Jenis Pengaduan --</option>
                                <option value="bullying" {{ old('jenis_pengaduan') == 'bullying' ? 'selected' : '' }}>Bullying</option>
                                <option value="kenakalanremaja" {{ old('jenis_pengaduan') == 'kenakalanremaja' ? 'selected' : '' }}>Kenakalan Remaja</option>
                                <option value="kekerasan" {{ old('jenis_pengaduan') == 'kekerasan' ? 'selected' : '' }}>Kekerasan</option>
                                <option value="diskriminasi" {{ old('jenis_pengaduan') == 'diskriminasi' ? 'selected' : '' }}>Diskriminasi</option>
                                <option value="lainnya" {{ old('jenis_pengaduan') == 'lainnya' ? 'selected' : '' }}>Lainnya</option>
                            </select>
                            @error('jenis_pengaduan')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Laporan Pengaduan -->
                        <div>
                            <label for="laporan_pengaduan" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Laporan Pengaduan <span class="text-red-500">*</span>
                            </label>
                            <textarea name="laporan_pengaduan" id="laporan_pengaduan" rows="5" required
                                      placeholder="Jelaskan detail pengaduan secara lengkap..."
                                      class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white">{{ old('laporan_pengaduan') }}</textarea>
                            @error('laporan_pengaduan')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Gambar -->
                        <div>
                            <label for="gambar" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Gambar Pendukung (Opsional)
                            </label>
                            <input type="file" name="gambar" id="gambar" accept="image/*"
                                   class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white">
                            <p class="mt-1 text-sm text-gray-500">Format yang didukung: JPG, PNG, GIF. Maksimal 2MB.</p>
                            @error('gambar')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Tombol Submit -->
                        <div class="flex justify-end space-x-3">
                            <a href="{{ route('pengaduan.index') }}" 
                               class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                                Batal
                            </a>
                            <button type="submit" 
                                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                <i class="fas fa-save mr-2"></i>Simpan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
