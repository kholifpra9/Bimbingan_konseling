<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Detail Pengaduan') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    
                    <!-- Header -->
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-lg font-semibold">Detail Pengaduan</h3>
                        <div class="space-x-2">
                            @hasrole('admin|gurubk')
                            <a href="{{ route('pengaduan.edit', $pengaduan->id) }}" 
                               class="bg-indigo-500 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded">
                                <i class="fas fa-edit mr-2"></i>Edit
                            </a>
                            @endhasrole
                            <a href="{{ route('pengaduan.index') }}" 
                               class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                                <i class="fas fa-arrow-left mr-2"></i>Kembali
                            </a>
                        </div>
                    </div>

                    <!-- Detail Pengaduan -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Informasi Dasar -->
                        <div class="space-y-4">
                            <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                                <h4 class="font-semibold text-gray-700 dark:text-gray-300 mb-3">Informasi Dasar</h4>
                                
                                <div class="space-y-3">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-600 dark:text-gray-400">NIS</label>
                                        <p class="text-gray-900 dark:text-gray-100">{{ $pengaduan->nis }}</p>
                                    </div>
                                    
                                    <div>
                                        <label class="block text-sm font-medium text-gray-600 dark:text-gray-400">Tanggal Pengaduan</label>
                                        <p class="text-gray-900 dark:text-gray-100">{{ \Carbon\Carbon::parse($pengaduan->tgl_pengaduan)->format('d F Y') }}</p>
                                    </div>
                                    
                                    <div>
                                        <label class="block text-sm font-medium text-gray-600 dark:text-gray-400">Jenis Pengaduan</label>
                                        <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full 
                                            {{ $pengaduan->jenis_pengaduan == 'bullying' ? 'bg-red-100 text-red-800' : 
                                               ($pengaduan->jenis_pengaduan == 'kenakalanremaja' ? 'bg-yellow-100 text-yellow-800' : 
                                               ($pengaduan->jenis_pengaduan == 'kekerasan' ? 'bg-red-100 text-red-800' : 
                                               ($pengaduan->jenis_pengaduan == 'diskriminasi' ? 'bg-purple-100 text-purple-800' : 'bg-gray-100 text-gray-800'))) }}">
                                            {{ ucfirst($pengaduan->jenis_pengaduan) }}
                                        </span>
                                    </div>

                                    @if(isset($pengaduan->status))
                                    <div>
                                        <label class="block text-sm font-medium text-gray-600 dark:text-gray-400">Status</label>
                                        <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full 
                                            {{ $pengaduan->status == 'selesai' ? 'bg-green-100 text-green-800' : 
                                               ($pengaduan->status == 'proses' ? 'bg-yellow-100 text-yellow-800' : 'bg-gray-100 text-gray-800') }}">
                                            {{ ucfirst($pengaduan->status ?? 'Pending') }}
                                        </span>
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Gambar -->
                        <div>
                            <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                                <h4 class="font-semibold text-gray-700 dark:text-gray-300 mb-3">Gambar Pendukung</h4>
                                @if($pengaduan->gambar)
                                    <div class="text-center">
                                        <img src="{{ asset('storage/images/' . $pengaduan->gambar) }}" 
                                             alt="Gambar Pengaduan" 
                                             class="max-w-full h-auto rounded-lg shadow-md cursor-pointer"
                                             onclick="openImageModal('{{ asset('storage/images/' . $pengaduan->gambar) }}')">
                                        <p class="text-sm text-gray-500 mt-2">Klik gambar untuk memperbesar</p>
                                    </div>
                                @else
                                    <div class="text-center py-8">
                                        <i class="fas fa-image text-4xl text-gray-400 mb-2"></i>
                                        <p class="text-gray-500">Tidak ada gambar</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Laporan Pengaduan -->
                    <div class="mt-6">
                        <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                            <h4 class="font-semibold text-gray-700 dark:text-gray-300 mb-3">Laporan Pengaduan</h4>
                            <div class="prose dark:prose-invert max-w-none">
                                <p class="text-gray-900 dark:text-gray-100 leading-relaxed">{{ $pengaduan->laporan_pengaduan }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Tanggapan (jika ada) -->
                    @if(isset($pengaduan->tanggapan) && $pengaduan->tanggapan)
                    <div class="mt-6">
                        <div class="bg-blue-50 dark:bg-blue-900 p-4 rounded-lg border-l-4 border-blue-500">
                            <h4 class="font-semibold text-blue-700 dark:text-blue-300 mb-3">
                                <i class="fas fa-reply mr-2"></i>Tanggapan Guru BK
                            </h4>
                            <div class="prose dark:prose-invert max-w-none">
                                <p class="text-blue-900 dark:text-blue-100 leading-relaxed">{{ $pengaduan->tanggapan }}</p>
                            </div>
                        </div>
                    </div>
                    @endif

                    <!-- Aksi -->
                    @hasrole('admin|gurubk')
                    <div class="mt-6 flex justify-end space-x-3">
                        <a href="{{ route('pengaduan.edit', $pengaduan->id) }}" 
                           class="bg-indigo-500 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded">
                            <i class="fas fa-edit mr-2"></i>Edit Pengaduan
                        </a>
                        <form action="{{ route('pengaduan.destroy', $pengaduan->id) }}" method="POST" class="inline" 
                              onsubmit="return confirm('Apakah Anda yakin ingin menghapus pengaduan ini?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                                <i class="fas fa-trash mr-2"></i>Hapus
                            </button>
                        </form>
                    </div>
                    @endhasrole
                </div>
            </div>
        </div>
    </div>

    <!-- Modal untuk gambar -->
    <div id="imageModal" class="fixed inset-0 bg-black bg-opacity-75 hidden z-50 flex items-center justify-center">
        <div class="max-w-4xl max-h-full p-4">
            <img id="modalImage" src="" alt="Gambar Pengaduan" class="max-w-full max-h-full object-contain">
            <button onclick="closeImageModal()" class="absolute top-4 right-4 text-white text-2xl hover:text-gray-300">
                <i class="fas fa-times"></i>
            </button>
        </div>
    </div>

    <script>
        function openImageModal(imageSrc) {
            document.getElementById('modalImage').src = imageSrc;
            document.getElementById('imageModal').classList.remove('hidden');
        }

        function closeImageModal() {
            document.getElementById('imageModal').classList.add('hidden');
        }

        // Close modal when clicking outside the image
        document.getElementById('imageModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeImageModal();
            }
        });
    </script>
</x-app-layout>
