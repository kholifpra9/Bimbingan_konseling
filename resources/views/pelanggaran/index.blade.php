<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Data Pelanggaran Siswa') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-lg rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    {{-- Tombol Tambah Data --}}
                    @role('kesiswaan')
                        <div class="mb-6">
                            <a href="{{ route('pelanggaran.create') }}"
                               class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-lg
                                      font-semibold text-xs text-white uppercase tracking-widest
                                      hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                                Tambah Data Pelanggaran
                            </a>
                        </div>
                    @endrole

                    {{-- Tabel --}}
                    <div class="overflow-x-auto">
                        <table class="min-w-full border border-gray-200 dark:border-gray-700 rounded-lg overflow-hidden">
                            <thead class="bg-gray-100 dark:bg-gray-700">
                                <tr>
                                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600 dark:text-gray-300 uppercase">Siswa</th>
                                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600 dark:text-gray-300 uppercase">Jenis Pelanggaran</th>
                                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600 dark:text-gray-300 uppercase">Poin</th>
                                    @role('kesiswaan')
                                        <th class="px-6 py-3 text-center text-sm font-semibold text-gray-600 dark:text-gray-300 uppercase">Aksi</th>
                                    @endrole
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                                @forelse ($pelanggaran as $item)
                                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $item->siswa->nama ?? 'Siswa tidak ditemukan' }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $item->jenis_pelanggaran }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $item->point_pelanggaran }}</td>
                                        @role('kesiswaan')
                                            <td class="px-6 py-4 whitespace-nowrap text-center space-x-2">
                                                <a href="{{ route('pelanggaran.edit', $item->id) }}"
                                                   class="inline-flex items-center px-3 py-1 bg-indigo-600 text-white text-xs font-semibold rounded-md hover:bg-indigo-700">
                                                    Edit
                                                </a>
                                                <form action="{{ route('pelanggaran.destroy', $item->id) }}" method="POST" class="inline"
                                                      onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                            class="inline-flex items-center px-3 py-1 bg-red-600 text-white text-xs font-semibold rounded-md hover:bg-red-700">
                                                        Hapus
                                                    </button>
                                                </form>
                                            </td>
                                        @endrole
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="px-6 py-4 text-center text-gray-500 dark:text-gray-400">
                                            Tidak ada data pelanggaran.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
