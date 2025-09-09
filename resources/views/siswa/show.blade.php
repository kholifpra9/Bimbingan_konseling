<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Detail Data Siswa') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    
                    <!-- Back Button -->
                    <div class="mb-6">
                        <a href="{{ route('siswa.index') }}" 
                           class="inline-flex items-center px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white font-semibold rounded-lg transition-all duration-200">
                            <i class="fas fa-arrow-left mr-2"></i>
                            Kembali ke Daftar Siswa
                        </a>
                    </div>

                    <!-- Student Profile Card -->
                    <div class="bg-gradient-to-r from-blue-50 to-indigo-50 rounded-lg p-6 border border-gray-200">
                        <div class="flex items-center space-x-4 mb-6">
                            <div class="w-16 h-16 bg-blue-500 rounded-full flex items-center justify-center">
                                <i class="fas fa-user text-white text-2xl"></i>
                            </div>
                            <div>
                                <h3 class="text-2xl font-bold text-gray-900">{{ $siswa->nama }}</h3>
                                <p class="text-gray-600">NIS: {{ $siswa->nis }}</p>
                            </div>
                        </div>

                        <!-- Student Details -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="space-y-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">NIS</label>
                                    <div class="bg-white p-3 rounded-lg border border-gray-300">
                                        {{ $siswa->nis }}
                                    </div>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap</label>
                                    <div class="bg-white p-3 rounded-lg border border-gray-300">
                                        {{ $siswa->nama }}
                                    </div>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Kelas</label>
                                    <div class="bg-white p-3 rounded-lg border border-gray-300">
                                        {{ $siswa->kelas }}
                                    </div>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Jurusan</label>
                                    <div class="bg-white p-3 rounded-lg border border-gray-300">
                                        {{ $siswa->jurusan }}
                                    </div>
                                </div>
                            </div>

                            <div class="space-y-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Jenis Kelamin</label>
                                    <div class="bg-white p-3 rounded-lg border border-gray-300">
                                        {{ $siswa->jenis_kelamin }}
                                    </div>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">No. Telepon</label>
                                    <div class="bg-white p-3 rounded-lg border border-gray-300">
                                        {{ $siswa->no_tlp }}
                                    </div>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Alamat</label>
                                    <div class="bg-white p-3 rounded-lg border border-gray-300">
                                        {{ $siswa->alamat }}
                                    </div>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Terdaftar</label>
                                    <div class="bg-white p-3 rounded-lg border border-gray-300">
                                        {{ $siswa->created_at->format('d M Y, H:i') }}
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Action Buttons for Admin/GuruBK -->
                        @if(auth()->user()->hasRole('admin') || auth()->user()->hasRole('gurubk'))
                        <div class="mt-6 pt-6 border-t border-gray-200">
                            <div class="flex space-x-4">
                                <a href="{{ route('siswa.edit', $siswa->id) }}" 
                                   class="inline-flex items-center px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg transition-all duration-200">
                                    <i class="fas fa-edit mr-2"></i>
                                    Edit Data
                                </a>
                                
                                <button type="button"
                                        class="inline-flex items-center px-6 py-3 bg-red-600 hover:bg-red-700 text-white font-semibold rounded-lg transition-all duration-200"
                                        onclick="confirmDelete({{ $siswa->id }})">
                                    <i class="fas fa-trash mr-2"></i>
                                    Hapus Data
                                </button>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div id="deleteModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <div class="mt-3 text-center">
                <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-red-100">
                    <i class="fas fa-exclamation-triangle text-red-600 text-xl"></i>
                </div>
                <h3 class="text-lg font-medium text-gray-900 mt-4">Konfirmasi Hapus</h3>
                <div class="mt-2 px-7 py-3">
                    <p class="text-sm text-gray-500">
                        Apakah Anda yakin ingin menghapus data siswa ini? Tindakan ini tidak dapat dibatalkan.
                    </p>
                </div>
                <div class="items-center px-4 py-3">
                    <form id="deleteForm" method="POST" style="display: inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                                class="px-4 py-2 bg-red-500 text-white text-base font-medium rounded-md w-24 mr-2 hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-red-300">
                            Hapus
                        </button>
                    </form>
                    <button onclick="closeDeleteModal()"
                            class="px-4 py-2 bg-gray-500 text-white text-base font-medium rounded-md w-24 hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-300">
                        Batal
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        function confirmDelete(siswaId) {
            const modal = document.getElementById('deleteModal');
            const form = document.getElementById('deleteForm');
            form.action = `/siswa/${siswaId}`;
            modal.classList.remove('hidden');
        }

        function closeDeleteModal() {
            const modal = document.getElementById('deleteModal');
            modal.classList.add('hidden');
        }

        // Close modal when clicking outside
        document.getElementById('deleteModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeDeleteModal();
            }
        });
    </script>
</x-app-layout>
