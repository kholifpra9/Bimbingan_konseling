<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
        @if(auth()->user()->hasRole('gurubk'))
            {{ __('Data Rekap Bimbingan') }}
        @else
            {{ __('Bimbingan Konseling') }}  
        @endif  
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-lg sm:rounded-xl">
            <div class="px-6 pt-6 pb-2 border-b border-gray-200 dark:border-gray-700">
                <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-lg font-semibold">Tambah Rekap Bimbingan</h3>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Lengkapi data berikut dengan benar.</p>
                </div>
                <div class="flex items-center gap-2">
                    <a href="{{ auth()->user()->hasRole('gurubk') ? route('rekap.index') : route('dashboard') }}"
                    class="inline-flex items-center gap-2 text-sm px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 hover:bg-gray-100 dark:hover:bg-gray-700 transition">
                    ← Kembali
                    </a>
                    <button form="rekapForm" type="submit"
                            class="inline-flex items-center gap-2 text-sm px-5 py-2.5 rounded-lg bg-blue-600 hover:bg-blue-700 text-white font-medium shadow">
                    Simpan
                    </button>
                </div>
                </div>
            </div>

            <form id="rekapForm" action="{{ route('rekap.store') }}" method="POST" class="p-6 space-y-8" novalidate>
                @csrf

                {{-- Error global --}}
                @if ($errors->any())
                <div class="rounded-lg border border-red-300 bg-red-50 text-red-800 p-4">
                    <div class="font-semibold mb-2">Periksa kembali input kamu:</div>
                    <ul class="list-disc list-inside space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                    </ul>
                </div>
                @endif

                {{-- Section: Data Siswa --}}
                <section>
                <h4 class="text-sm font-semibold text-gray-700 dark:text-gray-200 mb-3">Data Siswa</h4>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="max-w-xl">
                    <x-input-label for="id_siswa" value="Siswa" />

                    @php
                        $isGuruBk = auth()->user()->hasRole('gurubk');
                    @endphp

                    @if($isGuruBk)
                        <select id="id_siswa" name="id_siswa"
                                class="mt-1 block w-full rounded-lg border-gray-300 dark:border-gray-600 text-black px-3 py-2 bg-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                required aria-required="true" autofocus>
                        <option value="" disabled {{ old('id_siswa') ? '' : 'selected' }}>Pilih Siswa</option>
                        @foreach ($siswas as $siswa)
                            <option value="{{ $siswa->id }}" {{ old('id_siswa') == $siswa->id ? 'selected' : '' }}>
                            {{ $siswa->nis }} — {{ $siswa->nama }} ({{ $siswa->kelas }})
                            </option>
                        @endforeach
                        </select>
                    @else
                        {{-- Role siswa: kunci id_siswa + tampilkan ringkasan --}}
                        <input type="hidden" name="id_siswa" value="{{ old('id_siswa', optional($mySiswa)->id) }}">
                        <div class="mt-1 rounded-lg border border-gray-200 dark:border-gray-700 p-4 bg-gray-50 dark:bg-gray-900">
                        <dl class="grid grid-cols-3 gap-y-2 text-sm">
                            <dt class="text-gray-500 dark:text-gray-400">NIS</dt>
                            <dd class="col-span-2 font-semibold">{{ optional($mySiswa)->nis ?? '-' }}</dd>

                            <dt class="text-gray-500 dark:text-gray-400">Nama</dt>
                            <dd class="col-span-2 font-semibold">{{ optional($mySiswa)->nama ?? '-' }}</dd>

                            <dt class="text-gray-500 dark:text-gray-400">Kelas</dt>
                            <dd class="col-span-2 font-semibold">{{ optional($mySiswa)->kelas ?? '-' }}</dd>
                        </dl>
                        </div>
                    @endif

                    <x-input-error class="mt-2" :messages="$errors->get('id_siswa')" />
                    <p class="mt-1 text-xs text-gray-500">Wajib diisi.</p>
                    </div>
                </div>
                </section>

                <hr class="border-gray-200 dark:border-gray-700">

                {{-- Section: Detail Bimbingan --}}
                <section>
                <h4 class="text-sm font-semibold text-gray-700 dark:text-gray-200 mb-3">Detail Bimbingan</h4>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    {{-- Jenis Bimbingan --}}
                    <div class="max-w-xl">
                    <x-input-label for="jenis_bimbingan" value="Jenis Bimbingan" />
                    <x-select-input id="jenis_bimbingan" name="jenis_bimbingan"
                                    class="mt-1 block w-full" required aria-required="true">
                        <option value="" disabled {{ old('jenis_bimbingan') ? '' : 'selected' }}>Pilih Jenis Bimbingan</option>
                        <option value="Sosial"   {{ old('jenis_bimbingan')==='Sosial'   ? 'selected' : '' }}>Sosial</option>
                        <option value="Akademik" {{ old('jenis_bimbingan')==='Akademik' ? 'selected' : '' }}>Akademik</option>
                        <option value="Pribadi"  {{ old('jenis_bimbingan')==='Pribadi'  ? 'selected' : '' }}>Pribadi</option>
                    </x-select-input>
                    <x-input-error class="mt-2" :messages="$errors->get('jenis_bimbingan')" />
                    <p class="mt-1 text-xs text-gray-500">Contoh: Akademik untuk masalah nilai/tugas.</p>
                    </div>

                    {{-- Tanggal Bimbingan --}}
                    <div class="max-w-xl">
                    <x-input-label for="tgl_bimbingan" value="Tanggal Bimbingan" />
                    <input type="date" id="tgl_bimbingan" name="tgl_bimbingan"
                            value="{{ old('tgl_bimbingan', now()->toDateString()) }}"
                            class="mt-1 block w-full rounded-lg border-gray-300 dark:border-gray-600 text-black px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                            required aria-required="true" />
                    <x-input-error class="mt-2" :messages="$errors->get('tgl_bimbingan')" />
                    </div>

                    {{-- Keterangan (full width on md) --}}
                    <div class="md:col-span-2 max-w-3xl">
                    <x-input-label for="keterangan" value="Keterangan" />
                    <textarea id="keterangan" name="keterangan" rows="4"
                                class="mt-1 block w-full rounded-lg border border-gray-300 dark:border-gray-600 text-black px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                placeholder="Tuliskan ringkasan bimbingan (tujuan, topik, tindak lanjut)..."
                                required aria-required="true">{{ old('keterangan') }}</textarea>
                    <x-input-error class="mt-2" :messages="$errors->get('keterangan')" />
                    <p class="mt-1 text-xs text-gray-500">Berikan deskripsi singkat yang jelas (min 10–20 kata).</p>
                    </div>
                </div>
                </section>

                {{-- Actions (duplikat bawah untuk kenyamanan) --}}
                <div class="flex items-center justify-end gap-3">
                <a href="{{ auth()->user()->hasRole('gurubk') ? route('rekap.index') : route('dashboard') }}"
                    class="px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 hover:bg-gray-100 dark:hover:bg-gray-700">
                    Batal
                </a>
                <button type="submit" name="save" value="true"
                        class="px-5 py-2.5 rounded-lg bg-blue-600 hover:bg-blue-700 text-white font-medium shadow">
                    Simpan
                </button>
                </div>
            </form>
            </div>
        </div>
    </div>

</x-app-layout>