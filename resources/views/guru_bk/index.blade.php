@include('guru_bk.delete')

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Data Guru BK') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    
                    {{-- Tombol Tambah Data hanya untuk Admin --}}
                    @hasrole('admin')
                        <a href="{{ route('guru_bk.create') }}" 
                           class="mb-4 inline-block text-black border border-black p-2 rounded-lg hover:bg-black hover:text-white transition">
                            Tambah Data
                        </a>
                    @endhasrole

                    {{-- Tabel Data Guru BK --}}
                    <x-table>
                        <x-slot name="header">
                            <thead class="bg-gray-100 dark:bg-gray-700">
                                <tr>
                                    <th class="px-4 py-2">No</th>
                                    <th class="px-4 py-2">NIP</th>
                                    <th class="px-4 py-2">Nama</th>
                                    <th class="px-4 py-2">Jenis Kelamin</th>
                                    <th class="px-4 py-2">No Telepon</th>
                                    <th class="px-4 py-2">Alamat</th>
                                    @hasrole('admin')
                                        <th class="px-4 py-2">Aksi</th>
                                    @endhasrole
                                </tr>
                            </thead>
                        </x-slot>

                        <tbody>
                            @php $num = 1; @endphp
                            @foreach ($guru_bk as $data)
                                <tr class="border-b border-gray-200 dark:border-gray-700">
                                    <td class="px-4 py-2">{{ $num++ }}</td>
                                    <td class="px-4 py-2">{{ $data->nip }}</td>
                                    <td class="px-4 py-2">
                                        <a href="{{ route('guru_bk.show', $data->id) }}" 
                                           class="text-blue-600 hover:text-blue-800 hover:underline">
                                            {{ $data->nama }}
                                        </a>
                                    </td>
                                    <td class="px-4 py-2">{{ $data->jenis_kelamin }}</td>
                                    <td class="px-4 py-2">{{ $data->no_tlp }}</td>
                                    <td class="px-4 py-2">{{ $data->alamat }}</td>

                                    @hasrole('admin')
                                        <td class="px-4 py-2 flex space-x-2">
                                            {{-- Tombol Edit --}}
                                            <a href="{{ route('guru_bk.edit', $data->id) }}"
                                               class="bg-blue-600 hover:bg-blue-800 text-white font-bold py-2 px-4 rounded">
                                                EDIT
                                            </a>

                                            {{-- Tombol Hapus dengan Modal --}}
                                            <button type="button"
                                                    class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#hapusModal_{{ $data->id }}">
                                                HAPUS
                                            </button>
                                        </td>
                                    @endhasrole
                                </tr>
                            @endforeach
                        </tbody>
                    </x-table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
