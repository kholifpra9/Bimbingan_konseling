<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Data Siswa') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form action="{{ route('siswa.store') }}" method="POST" novalidate class="space-y-6">
                        @csrf

                        <div class="flex items-center justify-between">
                            <a href="{{ route('siswa.index') }}"
                            class="inline-flex items-center gap-2 text-sm px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 hover:bg-gray-100 dark:hover:bg-gray-700 transition">
                                ← Kembali
                            </a>
                            <button type="submit"
                                    name="save"
                                    value="true"
                                    class="inline-flex items-center gap-2 text-sm px-5 py-2.5 rounded-lg bg-blue-600 hover:bg-blue-700 text-white font-medium shadow">
                                Simpan
                            </button>
                        </div>

                        {{-- Error global (validasi server) --}}
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

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            {{-- NIS --}}
                            <div>
                                <label for="nis" class="block text-sm font-medium mb-1">NIS</label>
                                <input type="text" id="nis" name="nis"
                                    inputmode="numeric" pattern="[0-9]{4,}"
                                    placeholder="cth: 123456"
                                    value="{{ old('nis') }}"
                                    class="w-full rounded-lg border-gray-300 dark:border-gray-600 text-black px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                    required aria-required="true" autofocus>
                                @error('nis')
                                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Nama --}}
                            <div>
                                <label for="nama" class="block text-sm font-medium mb-1">Nama</label>
                                <input type="text" id="nama" name="nama"
                                    placeholder="cth: Budi Santoso"
                                    value="{{ old('nama') }}"
                                    class="w-full rounded-lg border-gray-300 dark:border-gray-600 text-black px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                    required aria-required="true">
                                @error('nama')
                                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Email --}}
                            <div>
                                <label for="email" class="block text-sm font-medium mb-1">Email</label>
                                <input type="email" id="email" name="email"
                                    placeholder="nama@sekolah.sch.id"
                                    value="{{ old('email') }}"
                                    autocomplete="email"
                                    class="w-full rounded-lg border-gray-300 dark:border-gray-600 text-black px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                    required aria-required="true">
                                @error('email')
                                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Kelas --}}
                            <div>
                                <label for="kelas" class="block text-sm font-medium mb-1">Kelas</label>
                                <input type="text" id="kelas" name="kelas"
                                    placeholder="cth: X-1 / XI-2 / XII-3"
                                    value="{{ old('kelas') }}"
                                    class="w-full rounded-lg border-gray-300 dark:border-gray-600 text-black px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                    required aria-required="true">
                                @error('kelas')
                                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Jurusan --}}
                            <div>
                                <label for="jurusan" class="block text-sm font-medium mb-1">Jurusan</label>
                                <input type="text" id="jurusan" name="jurusan"
                                    placeholder="cth: RPL / TKJ / AKL"
                                    value="{{ old('jurusan') }}"
                                    class="w-full rounded-lg border-gray-300 dark:border-gray-600 text-black px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                    required aria-required="true">
                                @error('jurusan')
                                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Jenis Kelamin --}}
                            <div>
                                <label for="jenis_kelamin" class="block text-sm font-medium mb-1">Jenis Kelamin</label>
                                <select id="jenis_kelamin" name="jenis_kelamin"
                                        class="w-full rounded-lg border-gray-300 dark:border-gray-600 text-black px-3 py-2 bg-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                        required aria-required="true">
                                    <option value="" disabled {{ old('jenis_kelamin') ? '' : 'selected' }}>Pilih</option>
                                    <option value="Laki-laki" {{ old('jenis_kelamin') === 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                                    <option value="Perempuan" {{ old('jenis_kelamin') === 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                                </select>
                                @error('jenis_kelamin')
                                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Nomor HP --}}
                            <div>
                                <label for="no_tlp" class="block text-sm font-medium mb-1">Nomor HP</label>
                                <input type="tel" id="no_tlp" name="no_tlp"
                                    inputmode="tel" pattern="^[0-9+()\-\s]{8,}$"
                                    placeholder="cth: 081234567890"
                                    value="{{ old('no_tlp') }}"
                                    autocomplete="tel"
                                    class="w-full rounded-lg border-gray-300 dark:border-gray-600 text-black px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                    required aria-required="true">
                                @error('no_tlp')
                                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Alamat --}}
                            <div class="md:col-span-2">
                                <label for="alamat" class="block text-sm font-medium mb-1">Alamat</label>
                                <textarea id="alamat" name="alamat" rows="3"
                                        placeholder="Nama jalan, RT/RW, Kel/Desa, Kec., Kab/Kota"
                                        class="w-full rounded-lg border-gray-300 dark:border-gray-600 text-black px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                        required aria-required="true">{{ old('alamat') }}</textarea>
                                @error('alamat')
                                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="flex items-center justify-end gap-3 pt-2">
                            <button type="reset"
                                    class="px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 hover:bg-gray-100 dark:hover:bg-gray-700">
                                Reset
                            </button>
                            <button type="submit"
                                    name="save"
                                    value="true"
                                    class="px-5 py-2.5 rounded-lg bg-blue-600 hover:bg-blue-700 text-white font-medium shadow">
                                Simpan
                            </button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>