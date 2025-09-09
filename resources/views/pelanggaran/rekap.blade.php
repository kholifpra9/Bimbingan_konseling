<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Rekap Pelanggaran Siswa') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-lg rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    {{-- Search --}}
                    <form method="GET" class="mb-6">
                        <div class="flex gap-3">
                            <input type="text" name="q" value="{{ request('q') }}"
                                   placeholder="Cari NIS / Nama / Kelas"
                                   class="w-full md:w-1/2 rounded-lg border-gray-300 dark:border-gray-600 text-black px-3 py-2">
                            <button class="px-4 py-2 bg-blue-600 text-white rounded-lg">Cari</button>
                        </div>
                    </form>

                    <div class="overflow-x-auto">
                        <table class="min-w-full border border-gray-200 dark:border-gray-700 rounded-lg overflow-hidden">
                            <thead class="bg-gray-100 dark:bg-gray-700">
                                <tr>
                                    <th class="px-6 py-3 text-left text-sm font-semibold uppercase text-gray-600 dark:text-gray-300">NIS</th>
                                    <th class="px-6 py-3 text-left text-sm font-semibold uppercase text-gray-600 dark:text-gray-300">Nama</th>
                                    <th class="px-6 py-3 text-left text-sm font-semibold uppercase text-gray-600 dark:text-gray-300">Kelas</th>
                                    <th class="px-6 py-3 text-right text-sm font-semibold uppercase text-gray-600 dark:text-gray-300">Total Poin</th>
                                    <th class="px-6 py-3 text-center text-sm font-semibold uppercase text-gray-600 dark:text-gray-300">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                                @forelse ($siswa as $row)
                                    @php
                                        $tp = $row->total_point ?? 0;
                                    @endphp
                                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $row->nis }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $row->nama }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $row->kelas }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right font-semibold">
                                            {{ $row->total_point ?? 0 }}
                                            @if(($row->total_point ?? 0) >= 65)
                                                <span class="ml-2 inline-flex items-center px-2 py-0.5 text-xs font-medium rounded-full bg-red-100 text-red-800">
                                                    Kritis
                                                </span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-center space-x-2">
                                            <a href="{{ route('pelanggaran.rekap.detail', $row->nis) }}"
                                            class="inline-flex items-center px-3 py-1 bg-indigo-600 text-white text-xs font-semibold rounded-md hover:bg-indigo-700">
                                                Detail
                                            </a>

                                            @role('kesiswaan')
                                            <a href="{{ route('pelanggaran.create', ['nis' => $row->nis]) }}"
                                            class="inline-flex items-center px-3 py-1 bg-red-600 text-white text-xs font-semibold rounded-md hover:bg-green-700">
                                                Tambah Pelanggaran
                                            </a>
                                            @endrole

                                            @role('kesiswaan|gurubk')
                                            @if(($row->total_point ?? 0) >= 65)
                                                <a href="{{ route('pelanggaran.rekap.surat', $row->nis) }}"
                                                class="inline-flex items-center px-3 py-1 bg-orange-600 text-white text-xs font-semibold rounded-md hover:bg-red-700">
                                                    Cetak Surat
                                                </a>
                                            @endif
                                            @endrole
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-6 py-4 text-center text-gray-500 dark:text-gray-400">
                                            Belum ada data siswa / pelanggaran.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-6">
                        {{ $siswa->links() }}
                    </div>

                </div>
            </div>

        </div>
    </div>
</x-app-layout>
