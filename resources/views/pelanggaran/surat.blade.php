<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Surat Pemanggilan Orang Tua') }}
        </h2>
    </x-slot>

    <div class="py-8 print:py-0">
        <div class="max-w-3xl mx-auto bg-white dark:bg-gray-900 shadow print:shadow-none rounded-lg p-8 print:p-0">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <div class="text-lg font-bold">SMKN NEGERI 1 CILAKU</div>
                    <div class="text-sm text-gray-600">Jl. .......................................</div>
                    <div class="text-sm text-gray-600">Telp. 0xxx-xxxxxxx</div>
                </div>
                <div class="text-right">
                    <div class="text-sm text-gray-600">Cianjur, {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}</div>
                    <div class="text-sm">No:  /SMK/PKS/{{ \Carbon\Carbon::now()->format('m/Y') }}</div>
                </div>
            </div>

            <hr class="my-4">

            <div class="mb-4">
                <div class="font-semibold">Perihal: Pemanggilan Orang Tua/Wali Siswa</div>
                <div class="mt-2">Kepada Yth.</div>
                <div>Orang Tua/Wali dari:</div>
            </div>

            <div class="mb-6">
                <table class="w-full">
                    <tr>
                        <td class="py-1 w-40">Nama</td><td class="py-1">: {{ $siswa->nama }}</td>
                    </tr>
                    <tr>
                        <td class="py-1">NIS</td><td class="py-1">: {{ $siswa->nis }}</td>
                    </tr>
                    <tr>
                        <td class="py-1">Kelas</td><td class="py-1">: {{ $siswa->kelas }}</td>
                    </tr>
                    <tr>
                        <td class="py-1 align-top">Total Poin</td>
                        <td class="py-1">: <span class="font-bold text-red-600">{{ $total }}</span></td>
                    </tr>
                </table>
            </div>

            <p class="mb-4 leading-relaxed">
                Sehubungan dengan pelanggaran tata tertib sekolah yang telah dilakukan oleh putra/putri Bapak/Ibu,
                bersama ini kami mengundang Bapak/Ibu/Wali untuk hadir ke sekolah pada:
            </p>

            <div class="mb-6">
                <table>
                    <tr><td class="py-1 w-40">Hari/Tanggal</td><td class="py-1">: .....................................</td></tr>
                    <tr><td class="py-1">Waktu</td><td class="py-1">: .....................................</td></tr>
                    <tr><td class="py-1">Tempat</td><td class="py-1">: Ruang BK SMKN Negeri 1 Cilaku</td></tr>
                    <tr><td class="py-1">Keperluan</td><td class="py-1">: Klarifikasi & pembinaan terkait pelanggaran</td></tr>
                </table>
            </div>

            <div class="mb-4">
                <div class="font-semibold mb-2">Ringkasan Pelanggaran:</div>
                <div class="overflow-x-auto">
                    <table class="min-w-full border border-gray-300">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="px-3 py-2 text-left text-sm font-semibold">Tanggal</th>
                                <th class="px-3 py-2 text-left text-sm font-semibold">Pelanggaran</th>
                                <th class="px-3 py-2 text-right text-sm font-semibold">Poin</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @foreach($pelanggaran as $p)
                                <tr>
                                    <td class="px-3 py-2">{{ $p->created_at?->format('d/m/Y') ?? '-' }}</td>
                                    <td class="px-3 py-2">{{ $p->jenis_pelanggaran }}</td>
                                    <td class="px-3 py-2 text-right">{{ $p->point_pelanggaran }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot class="bg-gray-50">
                            <tr>
                                <td class="px-3 py-2 font-semibold" colspan="2">Total</td>
                                <td class="px-3 py-2 text-right font-extrabold text-red-600">{{ $total }}</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>

            <p class="mt-6 leading-relaxed">
                Demikian pemberitahuan ini kami sampaikan. Atas perhatian dan kerjasamanya, kami ucapkan terima kasih.
            </p>

            <div class="flex justify-end mt-10">
                <div class="text-right">
                    <div>Hormat kami,</div>
                    <div>Wakil Kesiswaan / Guru BK</div>
                    <div class="h-16"></div>
                    <div class="font-semibold underline">__________________________</div>
                </div>
            </div>

            <div class="mt-8 flex items-center gap-2 print:hidden">
                <a href="{{ route('pelanggaran.rekap.detail', $siswa->nis) }}"
                   class="px-4 py-2 rounded-lg border border-gray-300 hover:bg-gray-100">
                    ← Kembali
                </a>
                <button onclick="window.print()"
                        class="px-4 py-2 rounded-lg bg-red-600 hover:bg-red-700 text-white">
                    Cetak
                </button>
            </div>
        </div>
    </div>
</x-app-layout>
