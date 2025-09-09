<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Hasil Daftar Cek Masalah Siswa') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    
                    <!-- Header -->
                    <div class="mb-6">
                        <h3 class="text-lg font-semibold mb-2">Hasil Formulir Cek Masalah</h3>
                        <p class="text-gray-600 dark:text-gray-400">
                            Berikut adalah daftar formulir cek masalah yang telah diisi oleh siswa. 
                            Anda dapat mereview dan memberikan tindak lanjut untuk setiap kasus.
                        </p>
                    </div>

                    @if(session('success'))
                        <div class="mb-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                            <strong class="font-bold">Berhasil!</strong>
                            <span class="block sm:inline">{{ session('success') }}</span>
                        </div>
                    @endif

                    @if($cekMasalahs->isEmpty())
                        <div class="text-center py-8">
                            <div class="text-gray-400 mb-4">
                                <i class="fas fa-clipboard-list text-6xl"></i>
                            </div>
                            <p class="text-gray-500 dark:text-gray-400 text-lg">Belum ada formulir cek masalah yang diisi siswa.</p>
                            <p class="text-gray-400 dark:text-gray-500 text-sm mt-2">Siswa dapat mengisi formulir melalui menu "Daftar Cek Masalah" di dashboard mereka.</p>
                        </div>
                    @else
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                                <thead class="bg-gray-50 dark:bg-gray-700">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                            Siswa
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                            Kategori
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                            Urgensi
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                            Status
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                            Tanggal
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                            Aksi
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                    @foreach($cekMasalahs as $cekMasalah)
                                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <div class="flex-shrink-0 h-10 w-10">
                                                    <div class="h-10 w-10 rounded-full bg-indigo-500 flex items-center justify-center">
                                                        <span class="text-sm font-medium text-white">
                                                            {{ substr($cekMasalah->siswa->nama ?? 'N/A', 0, 2) }}
                                                        </span>
                                                    </div>
                                                </div>
                                                <div class="ml-4">
                                                    <div class="text-sm font-medium text-gray-900 dark:text-gray-100">
                                                        {{ $cekMasalah->siswa->nama ?? 'N/A' }}
                                                    </div>
                                                    <div class="text-sm text-gray-500 dark:text-gray-300">
                                                        {{ $cekMasalah->siswa->kelas ?? '' }} {{ $cekMasalah->siswa->jurusan ?? '' }}
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full {{ $cekMasalah->kategori_masalah_badge }}">
                                                {{ $cekMasalah->kategori_masalah_string }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full {{ $cekMasalah->urgency_badge }}">
                                                {{ ucfirst($cekMasalah->tingkat_urgensi) }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full {{ $cekMasalah->status_badge }}">
                                                {{ $cekMasalah->status_text }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">
                                            {{ $cekMasalah->created_at->format('d/m/Y H:i') }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <button 
                                                x-data=""
                                                x-on:click.prevent="$dispatch('open-modal', 'detail-cek-masalah-{{ $cekMasalah->id }}')"
                                                class="text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-300 mr-3"
                                            >
                                                <i class="fas fa-eye mr-1"></i>Detail
                                            </button>
                                            <a href="{{ route('siswa.cek-masalah.dcm-report', $cekMasalah->id) }}"
                                                class="text-purple-600 hover:text-purple-900 dark:text-purple-400 dark:hover:text-purple-300 mr-3"
                                                title="Lihat DCM Report"
                                                target="_blank">
                                                <i class="fas fa-chart-bar mr-1"></i>DCM
                                            </a>
                                            <!-- <a href="{{ route('gurubk.cetak-surat-pemanggilan', $cekMasalah->id) }}"
                                                class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300 mr-3"
                                                title="Cetak Surat Pemanggilan Orang Tua"
                                                target="_blank">
                                                <i class="fas fa-envelope mr-1"></i>Surat
                                            </a> -->
                                            @if($cekMasalah->status == 'pending')
                                            <button 
                                                x-data=""
                                                x-on:click.prevent="$dispatch('open-modal', 'review-cek-masalah-{{ $cekMasalah->id }}')"
                                                class="text-green-600 hover:text-green-900 dark:text-green-400 dark:hover:text-green-300"
                                            >
                                                <i class="fas fa-edit mr-1"></i>Review
                                            </button>
                                            @endif
                                        </td>
                                    </tr>

                                    <!-- Modal Detail -->
                                    <x-modal name="detail-cek-masalah-{{ $cekMasalah->id }}" focusable>
                                        <div class="p-6">
                                            <h3 class="text-lg font-semibold mb-4">Detail Cek Masalah - {{ $cekMasalah->siswa->nama ?? 'N/A' }}</h3>
                                            
                                            <div class="space-y-4">
                                                <div>
                                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Kategori Masalah:</label>
                                                    <p class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $cekMasalah->kategori_masalah_string }}</p>
                                                </div>
                                                
                                                <div>
                                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Masalah yang Dipilih:</label>
                                                    <ul class="mt-1 text-sm text-gray-900 dark:text-gray-100 list-disc list-inside">
                                                        @foreach($cekMasalah->masalah_terpilih as $masalah)
                                                            <li>{{ $masalah }}</li>
                                                        @endforeach
                                                    </ul>
                                                </div>
                                                
                                                @if($cekMasalah->masalah_lain)
                                                <div>
                                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Masalah Lain:</label>
                                                    <p class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $cekMasalah->masalah_lain }}</p>
                                                </div>
                                                @endif
                                                
                                                <div>
                                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Tingkat Urgensi:</label>
                                                    <p class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ ucfirst($cekMasalah->tingkat_urgensi) }}</p>
                                                </div>
                                                
                                                @if($cekMasalah->deskripsi_tambahan)
                                                <div>
                                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Deskripsi Tambahan:</label>
                                                    <p class="mt-1 text-sm text-gray-900 dark:text-gray-100 whitespace-pre-wrap">{{ $cekMasalah->deskripsi_tambahan }}</p>
                                                </div>
                                                @endif
                                                
                                                @if($cekMasalah->catatan_guru)
                                                <div>
                                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Catatan Guru BK:</label>
                                                    <p class="mt-1 text-sm text-gray-900 dark:text-gray-100 whitespace-pre-wrap">{{ $cekMasalah->catatan_guru }}</p>
                                                </div>
                                                @endif
                                                
                                                @if($cekMasalah->tindak_lanjut)
                                                <div>
                                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Tindak Lanjut:</label>
                                                    <p class="mt-1 text-sm text-gray-900 dark:text-gray-100 whitespace-pre-wrap">{{ $cekMasalah->tindak_lanjut }}</p>
                                                </div>
                                                @endif
                                            </div>
                                            
                                            <div class="mt-6 text-right">
                                                <button x-on:click="$dispatch('close')" class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400">Tutup</button>
                                            </div>
                                        </div>
                                    </x-modal>

                                    <!-- Modal Review -->
                                    @if($cekMasalah->status == 'pending')
                                    <x-modal name="review-cek-masalah-{{ $cekMasalah->id }}" focusable>
                                        <form action="{{ route('gurubk.review-cek-masalah', $cekMasalah->id) }}" method="POST" class="p-6">
                                            @csrf
                                            @method('PUT')
                                            
                                            <h3 class="text-lg font-semibold mb-4">Review Cek Masalah - {{ $cekMasalah->siswa->nama ?? 'N/A' }}</h3>
                                            
                                            <div class="space-y-4">
                                                <div>
                                                    <label for="catatan_guru" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                                        Catatan Guru BK <span class="text-red-500">*</span>
                                                    </label>
                                                    <textarea name="catatan_guru" id="catatan_guru" rows="3" required
                                                              placeholder="Berikan catatan atau analisis terhadap masalah siswa..."
                                                              class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white"></textarea>
                                                </div>
                                                
                                                <div>
                                                    <label for="tindak_lanjut" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                                        Rencana Tindak Lanjut <span class="text-red-500">*</span>
                                                    </label>
                                                    <textarea name="tindak_lanjut" id="tindak_lanjut" rows="3" required
                                                              placeholder="Jelaskan rencana tindak lanjut yang akan dilakukan..."
                                                              class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white"></textarea>
                                                </div>
                                                
                                                <div>
                                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                                        Status <span class="text-red-500">*</span>
                                                    </label>
                                                    <div class="space-y-2">
                                                        <label class="flex items-center">
                                                            <input type="radio" name="status" value="reviewed" required class="text-blue-600 focus:ring-blue-500">
                                                            <span class="ml-2 text-sm text-blue-600">Sudah Direview</span>
                                                        </label>
                                                        <label class="flex items-center">
                                                            <input type="radio" name="status" value="follow_up" required class="text-orange-600 focus:ring-orange-500">
                                                            <span class="ml-2 text-sm text-orange-600">Perlu Tindak Lanjut</span>
                                                        </label>
                                                        <label class="flex items-center">
                                                            <input type="radio" name="status" value="completed" required class="text-green-600 focus:ring-green-500">
                                                            <span class="ml-2 text-sm text-green-600">Selesai</span>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <div class="mt-6 flex justify-end space-x-3">
                                                <button type="button" x-on:click="$dispatch('close')" class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400">Batal</button>
                                                <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700">Simpan Review</button>
                                            </div>
                                        </form>
                                    </x-modal>
                                    @endif
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
