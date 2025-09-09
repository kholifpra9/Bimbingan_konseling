<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Detail Guru BK') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="mb-6">
                        <a href="{{ route('guru_bk.index') }}"
                           class="inline-flex items-center px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white font-semibold rounded-lg transition-all duration-200">
                            <i class="fas fa-arrow-left mr-2"></i>
                            Kembali
                        </a>
                    </div>

                    <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-6">
                        <div class="flex items-center mb-6">
                            <div class="w-20 h-20 bg-green-500 rounded-full flex items-center justify-center text-white text-2xl font-bold mr-4">
                                {{ substr($guru_bk->nama, 0, 2) }}
                            </div>
                            <div>
                                <h3 class="text-2xl font-bold text-gray-900">{{ $guru_bk->nama }}</h3>
                                <p class="text-gray-600">NIP: {{ $guru_bk->nip }}</p>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <h4 class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">NIP</h4>
                                <div class="bg-white p-3 rounded-lg border border-gray-300">
                                    {{ $guru_bk->nip }}
                                </div>
                            </div>

                            <div>
                                <h4 class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Nama Lengkap</h4>
                                <div class="bg-white p-3 rounded-lg border border-gray-300">
                                    {{ $guru_bk->nama }}
                                </div>
                            </div>

                            <div>
                                <h4 class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Jenis Kelamin</h4>
                                <div class="bg-white p-3 rounded-lg border border-gray-300">
                                    {{ $guru_bk->jenis_kelamin }}
                                </div>
                            </div>

                            <div>
                                <h4 class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">No. Telepon</h4>
                                <div class="bg-white p-3 rounded-lg border border-gray-300">
                                    {{ $guru_bk->no_tlp }}
                                </div>
                            </div>

                            <div class="md:col-span-2">
                                <h4 class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Alamat</h4>
                                <div class="bg-white p-3 rounded-lg border border-gray-300">
                                    {{ $guru_bk->alamat }}
                                </div>
                            </div>

                            <div class="md:col-span-2">
                                <h4 class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Terdaftar Sejak</h4>
                                <div class="bg-white p-3 rounded-lg border border-gray-300">
                                    {{ $guru_bk->created_at->format('d M Y, H:i') }}
                                </div>
                            </div>
                        </div>

                        <!-- Action Buttons for Admin -->
                        @if(auth()->user()->hasRole('admin'))
                        <div class="mt-6 pt-6 border-t border-gray-200">
                            <div class="flex space-x-4">
                                <a href="{{ route('guru_bk.edit', $guru_bk->id) }}"
                                   class="inline-flex items-center px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg transition-all duration-200">
                                    <i class="fas fa-edit mr-2"></i>
                                    Edit Data
                                </a>
                                <button type="button"
                                        class="inline-flex items-center px-6 py-3 bg-red-600 hover:bg-red-700 text-white font-semibold rounded-lg transition-all duration-200"
                                        onclick="confirmDelete({{ $guru_bk->id }})">
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
    <div id="deleteModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <div class="mt-3 text-center">
                <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-red-100">
                    <i class="fas fa-exclamation-triangle text-red-600"></i>
                </div>
                <h3 class="text-lg leading-6 font-medium text-gray-900 mt-4">Hapus Data Guru BK</h3>
                <div class="mt-2 px-7 py-3">
                    <p class="text-sm text-gray-500">
                        Apakah Anda yakin ingin menghapus data guru BK ini? Tindakan ini tidak dapat dibatalkan.
                    </p>
                </div>
                <div class="items-center px-4 py-3">
                    <form id="deleteForm" method="POST" action="">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                                class="px-4 py-2 bg-red-600 text-white text-base font-medium rounded-md w-full shadow-sm hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500">
                            Ya, Hapus
                        </button>
                    </form>
                    <button onclick="closeModal()"
                            class="mt-3 px-4 py-2 bg-gray-300 text-gray-800 text-base font-medium rounded-md w-full shadow-sm hover:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-500">
                        Batal
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        function confirmDelete(guruBkId) {
            const modal = document.getElementById('deleteModal');
            const form = document.getElementById('deleteForm');
            form.action = `/guru_bk/${guruBkId}`;
            modal.classList.remove('hidden');
        }

        function closeModal() {
            const modal = document.getElementById('deleteModal');
            modal.classList.add('hidden');
        }
    </script>
</x-app-layout>
