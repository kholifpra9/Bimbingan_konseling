<x-app-layout>
    
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Edit Data Guru BK') }}
            </h2>
            <br>
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                @php
                    $guru_bk = App\Models\GuruBK::findOrFail($id);
                @endphp

                    <form method="post" action="{{ route('guru_bk.update', $guru_bk->id) }}">

                        @csrf
                        @method('PATCH')

                        <div class="max-w-xl">
                            <x-input-label for="nip" value="NIP" />
                            <x-text-input id="nip" type="text" name="nip" class="mt-1 block w-full" value="{{ old('nip', $guru_bk->nip) }}" required />
                            <x-input-error class="mt-2" :messages="$errors->get('nip')" />
                        </div>

                        <div class="max-w-xl">
                            <x-input-label for="nama" value="Nama" />
                            <x-text-input id="nama" type="text" name="nama" class="mt-1 block w-full" value="{{ old('nama', $guru_bk->nama) }}" required />
                            <x-input-error class="mt-2" :messages="$errors->get('nama')" />
                        </div>

                        <div class="max-w-xl">
                            <x-input-label for="jenis_kelamin" value="Jenis Kelamin" />
                            <!-- Select the option based on the old input or the $guru model -->
                            <select id="jenis_kelamin" name="jenis_kelamin" class="mt-1 block w-full" required>
                                <option value="">Pilih Jenis Kelamin</option>
                                <option value="Laki-Laki" {{ old('jenis_kelamin', $guru_bk->jenis_kelamin) == 'Laki-Laki' ? 'selected' : '' }}>Laki-laki</option>
                                <option value="Perempuan" {{ old('jenis_kelamin', $guru_bk->jenis_kelamin) == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                            </select>
                        </div>

                        <div class="max-w-xl">
                            <x-input-label for="alamat" value="Alamat" />
                            <x-text-input id="alamat" type="text" name="alamat" class="mt-1 block w-full" value="{{ old('alamat', $guru_bk->alamat) }}" required />
                            <x-input-error class="mt-2" :messages="$errors->get('alamat')" />
                        </div>

                        <div class="max-w-xl">
                            <x-input-label for="no_tlp" value="No Telepon" />
                            <x-text-input id="no_tlp" type="text" name="no_tlp" class="mt-1 block w-full" value="{{ old('no_telp', $guru_bk->no_tlp) }}" required />
                            <x-input-error class="mt-2" :messages="$errors->get('no_tlp')" />
                        </div>
                        
                        <div class="max-w-xl">
                            <x-input-label for="email" value="Email" />
                            <x-text-input id="email" type="text" name="email" class="mt-1 block w-full" value="{{ old('email', $guru_bk->user->email) }}" required />
                            <x-input-error class="mt-2" :messages="$errors->get('email')" />
                        </div>

                        <br>
                        <x-primary-button type="submit" name="simpan" value="true">
                            Simpan Data
                        </x-primary-button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>