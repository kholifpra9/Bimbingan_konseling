<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Detail Pelanggaran Siswa') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-lg rounded-lg mb-6">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="flex items-start justify-between">
                        <div>
                            <div class="text-sm text-gray-500 dark:text-gray-400">NIS</div>
                            <div class="text-lg font-semibold">{{ $siswa->nis }}</div>
                            <div class="mt-3 text-sm text-gray-500 dark:text-gray-400">Nama</div>
                            <div class="text-lg font-semibold">{{ $siswa->nama }}</div>
                            <div class="mt-3 text-sm text-gray-500 dark:text-gray-400">Kelas</div>
                            <div class="text-lg font-semibold">{{ $siswa->kelas }}</div>
                        </div>
                        <div class="text-right">
                            <div class="text-sm text-gray-500 dark:text-gray-400">Total Poin</div>
                            <div class="text-2xl font-extrabold text-red-600">{{ $total }}</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-lg rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-semibold">Riwayat Pelanggaran</h3>
                        <div class="flex items-center gap-2">
                            @if($total >= 65)
                                @role('kesiswaan|gurubk|kepsek')
                                <a href="{{ route('pelanggaran.rekap.surat', $siswa->nis) }}"
                                class="px-4 py-2 rounded-lg bg-red-600 hover:bg-red-700 text-white font-medium">
                                    Cetak Surat Pemanggilan
                                </a>
                                @endrole
                            @endif

                            <a href="{{ route('pelanggaran.rekap') }}"
                            class="px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 hover:bg-gray-100 dark:hover:bg-gray-700">
                                ← Kembali
                            </a>
                        </div>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="min-w-full border border-gray-200 dark:border-gray-700 rounded-lg overflow-hidden">
                            <thead class="bg-gray-100 dark:bg-gray-700">
                                <tr>
                                    <th class="px-6 py-3 text-left text-sm font-semibold uppercase text-gray-600 dark:text-gray-300">Tanggal</th>
                                    <th class="px-6 py-3 text-left text-sm font-semibold uppercase text-gray-600 dark:text-gray-300">Pelanggaran</th>
                                    <th class="px-6 py-3 text-right text-sm font-semibold uppercase text-gray-600 dark:text-gray-300">Poin</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                                @forelse($pelanggaran as $p)
                                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            {{ $p->created_at?->format('d M Y H:i') ?? '-' }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $p->jenis_pelanggaran }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right font-semibold">{{ $p->point_pelanggaran }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="px-6 py-4 text-center text-gray-500 dark:text-gray-400">
                                            Belum ada pelanggaran untuk siswa ini.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                            @if($pelanggaran->count())
                                <tfoot class="bg-gray-50 dark:bg-gray-900">
                                    <tr>
                                        <td class="px-6 py-3 font-semibold" colspan="2">Total</td>
                                        <td class="px-6 py-3 text-right font-extrabold text-red-600">{{ $total }}</td>
                                    </tr>
                                </tfoot>
                            @endif
                        </table>
                    </div>

                </div>
            </div>

        </div>
    </div>
</x-app-layout>
