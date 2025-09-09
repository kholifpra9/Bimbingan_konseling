<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Data Pelanggaran Siswa') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    <form action="{{ route('pelanggaran.store') }}" method="POST" class="space-y-6">
                        @csrf

                        <a href="{{ route('pelanggaran.rekap') }}"
                           class="inline-flex items-center gap-2 text-sm px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 hover:bg-gray-100 dark:hover:bg-gray-700 transition">
                            ← Kembali
                        </a>

                        <div class="grid grid-cols-1 gap-4">
                            {{-- === Field Siswa === --}}
                            <div class="max-w-xl">
                                <x-input-label for="id_siswa" value="Siswa" />

                                @if(isset($prefillSiswa) && $prefillSiswa)
                                    {{-- LOCKED: pakai hidden + tampilkan info --}}
                                    <input type="hidden" name="id_siswa" value="{{ $prefillSiswa->id }}">

                                    <div class="mt-1 rounded-lg border border-gray-200 dark:border-gray-700 p-3 bg-gray-50 dark:bg-gray-900">
                                        <div class="text-sm text-gray-500 dark:text-gray-400">NIS</div>
                                        <div class="font-semibold">{{ $prefillSiswa->nis }}</div>
                                        <div class="mt-2 text-sm text-gray-500 dark:text-gray-400">Nama</div>
                                        <div class="font-semibold">{{ $prefillSiswa->nama }}</div>
                                        <div class="mt-2 text-sm text-gray-500 dark:text-gray-400">Kelas</div>
                                        <div class="font-semibold">{{ $prefillSiswa->kelas }}</div>
                                    </div>
                                @else
                                    {{-- Dropdown biasa --}}
                                    <select id="id_siswa" name="id_siswa" class="mt-1 block w-full rounded-md text-black" required>
                                        <option value="" selected>Pilih Siswa</option>
                                        @foreach ($siswas as $siswa)
                                            <option value="{{ $siswa->id }}" {{ old('id_siswa') == $siswa->id ? 'selected' : '' }}>
                                                {{ $siswa->nis }} — {{ $siswa->nama }} ({{ $siswa->kelas }})
                                            </option>
                                        @endforeach
                                    </select>
                                @endif

                                <x-input-error class="mt-2" :messages="$errors->get('id_siswa')" />
                            </div>

                            {{-- Jenis Pelanggaran --}}
                            <div class="max-w-xl">
                                <x-input-label for="jenis_pelanggaran" value="Jenis Pelanggaran" />
                                <x-select-input id="jenis_pelanggaran" name="jenis_pelanggaran" class="mt-1 block w-full" required>
                                    <option value="" selected>Pilih Jenis Pelanggaran</option>
                                    <option value="Kenakalan Remaja" {{ old('jenis_pelanggaran')==='Kenakalan Remaja'?'selected':'' }}>Kenakalan Remaja</option>
                                    <option value="Bullying" {{ old('jenis_pelanggaran')==='Bullying'?'selected':'' }}>Bullying</option>
                                </x-select-input>
                                <x-input-error class="mt-2" :messages="$errors->get('jenis_pelanggaran')" />
                            </div>

                            {{-- Point --}}
                            <div class="max-w-xl">
                                <x-input-label for="point_pelanggaran" value="Point Pelanggaran" />
                                <input type="number" id="point_pelanggaran" name="point_pelanggaran"
                                       min="1" step="1"
                                       value="{{ old('point_pelanggaran') }}"
                                       class="mt-1 block w-full rounded-md text-black" required />
                                <x-input-error class="mt-2" :messages="$errors->get('point_pelanggaran')" />
                            </div>
                        </div>

                        <button value="true" type="submit" name="save"
                                class="inline-flex items-center px-5 py-2.5 rounded-lg bg-blue-600 hover:bg-blue-700 text-white font-medium shadow">
                            Simpan
                        </button>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
