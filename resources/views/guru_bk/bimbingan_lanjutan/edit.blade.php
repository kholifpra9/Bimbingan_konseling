<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Edit Bimbingan Lanjutan') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    
                    <!-- Header -->
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-lg font-semibold">Form Edit Bimbingan Lanjutan</h3>
                        <a href="{{ route('gurubk.bimbingan-lanjutan') }}" 
                           class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                            <i class="fas fa-arrow-left mr-2"></i>Kembali
                        </a>
                    </div>

                    <!-- Form -->
                    <form action="{{ route('gurubk.bimbingan-lanjutan.update', $bimbingan->id) }}" method="POST" class="space-y-6">
                        @csrf
                        @method('PATCH')

                        <!-- Pilih Siswa -->
                        <div>
                            <label for="id_siswa" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Pilih Siswa <span class="text-red-500">*</span>
                            </label>
                            <select name="id_siswa" id="id_siswa" required
                                    class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white">
                                <option value="">-- Pilih Siswa --</option>
                                @foreach($siswa as $s)
                                    <option value="{{ $s->id }}" {{ (old('id_siswa', $bimbingan->id_siswa) == $s->id) ? 'selected' : '' }}>
                                        {{ $s->nama }} - {{ $s->kelas }} {{ $s->jurusan }}
                                    </option>
                                @endforeach
                            </select>
                            @error('id_siswa')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Tanggal Bimbingan -->
                        <div>
                            <label for="tanggal_bimbingan" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Tanggal Bimbingan <span class="text-red-500">*</span>
                            </label>
                            <input type="date" name="tanggal_bimbingan" id="tanggal_bimbingan" 
                                   value="{{ old('tanggal_bimbingan', $bimbingan->tanggal_bimbingan) }}" required
                                   class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white">
                            @error('tanggal_bimbingan')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Masalah -->
                        <div>
                            <label for="masalah" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Masalah yang Dihadapi <span class="text-red-500">*</span>
                            </label>
                            <textarea name="masalah" id="masalah" rows="4" required
                                      placeholder="Jelaskan masalah yang dihadapi siswa secara detail..."
                                      class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white">{{ old('masalah', $bimbingan->masalah) }}</textarea>
                            @error('masalah')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Solusi -->
                        <div>
                            <label for="solusi" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Solusi yang Diberikan <span class="text-red-500">*</span>
                            </label>
                            <textarea name="solusi" id="solusi" rows="4" required
                                      placeholder="Jelaskan solusi atau saran yang diberikan kepada siswa..."
                                      class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white">{{ old('solusi', $bimbingan->solusi) }}</textarea>
                            @error('solusi')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Tindak Lanjut -->
                        <div>
                            <label for="tindak_lanjut" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Tindak Lanjut <span class="text-red-500">*</span>
                            </label>
                            <textarea name="tindak_lanjut" id="tindak_lanjut" rows="3" required
                                      placeholder="Jelaskan rencana tindak lanjut atau monitoring yang akan dilakukan..."
                                      class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white">{{ old('tindak_lanjut', $bimbingan->tindak_lanjut) }}</textarea>
                            @error('tindak_lanjut')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Tombol Submit -->
                        <div class="flex justify-end space-x-3">
                            <a href="{{ route('gurubk.bimbingan-lanjutan') }}" 
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
