<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Edit Pengaduan') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    
                    <!-- Header -->
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-lg font-semibold">Form Edit Pengaduan</h3>
                        <a href="{{ route('pengaduan.index') }}" 
                           class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                            <i class="fas fa-arrow-left mr-2"></i>Kembali
                        </a>
                    </div>

                    <!-- Form -->
                    <form action="{{ route('pengaduan.update', $pengaduan->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                        @csrf
                        @method('PATCH')

                        <!-- NIS -->
                        <div>
                            <label for="nis" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                NIS <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="nis" id="nis" 
                                   value="{{ old('nis', $pengaduan->nis) }}" required
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
                                   value="{{ old('tgl_pengaduan', $pengaduan->tgl_pengaduan) }}" required
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
                                <option value="bullying" {{ old('jenis_pengaduan', $pengaduan->jenis_pengaduan) == 'bullying' ? 'selected' : '' }}>Bullying</option>
                                <option value="kenakalanremaja" {{ old('jenis_pengaduan', $pengaduan->jenis_pengaduan) == 'kenakalanremaja' ? 'selected' : '' }}>Kenakalan Remaja</option>
                                <option value="kekerasan" {{ old('jenis_pengaduan', $pengaduan->jenis_pengaduan) == 'kekerasan' ? 'selected' : '' }}>Kekerasan</option>
                                <option value="diskriminasi" {{ old('jenis_pengaduan', $pengaduan->jenis_pengaduan) == 'diskriminasi' ? 'selected' : '' }}>Diskriminasi</option>
                                <option value="lainnya" {{ old('jenis_pengaduan', $pengaduan->jenis_pengaduan) == 'lainnya' ? 'selected' : '' }}>Lainnya</option>
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
                                      class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white">{{ old('laporan_pengaduan', $pengaduan->laporan_pengaduan) }}</textarea>
                            @error('laporan_pengaduan')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Status (hanya untuk admin/gurubk) -->
                        @hasrole('admin|gurubk')
                        <div>
                            <label for="status" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Status Pengaduan
                            </label>
                            <select name="status" id="status"
                                    class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white">
                                <option value="pending" {{ old('status', $pengaduan->status ?? 'pending') == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="proses" {{ old('status', $pengaduan->status ?? 'pending') == 'proses' ? 'selected' : '' }}>Dalam Proses</option>
                                <option value="selesai" {{ old('status', $pengaduan->status ?? 'pending') == 'selesai' ? 'selected' : '' }}>Selesai</option>
                            </select>
                            @error('status')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Tanggapan (hanya untuk admin/gurubk) -->
                        <div>
                            <label for="tanggapan" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Tanggapan Guru BK
                            </label>
                            <textarea name="tanggapan" id="tanggapan" rows="4"
                                      placeholder="Berikan tanggapan atau tindak lanjut untuk pengaduan ini..."
                                      class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white">{{ old('tanggapan', $pengaduan->tanggapan ?? '') }}</textarea>
                            @error('tanggapan')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        @endhasrole

                        <!-- Gambar Saat Ini -->
                        @if($pengaduan->gambar)
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Gambar Saat Ini
                            </label>
                            <div class="mb-4">
                                <img src="{{ asset('storage/images/' . $pengaduan->gambar) }}" 
                                     alt="Gambar Pengaduan" 
                                     class="h-32 w-32 object-cover rounded-lg shadow-md">
                            </div>
                        </div>
                        @endif

                        <!-- Upload Gambar Baru -->
                        <div>
                            <label for="gambar" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                {{ $pengaduan->gambar ? 'Ganti Gambar (Opsional)' : 'Gambar Pendukung (Opsional)' }}
                            </label>
                            <input type="file" name="gambar" id="gambar" accept="image/*"
                                   class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white">
                            <p class="mt-1 text-sm text-gray-500">
                                {{ $pengaduan->gambar ? 'Biarkan kosong jika tidak ingin mengganti gambar. ' : '' }}
                                Format yang didukung: JPG, PNG, GIF. Maksimal 2MB.
                            </p>
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
                                <i class="fas fa-save mr-2"></i>Update
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
