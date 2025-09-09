</div>
@include('siswa.delete')

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
                    
                    {{-- Tombol Tambah Data hanya untuk Admin & Guru BK --}}
                    @if (Auth::user()->hasRole('gurubk') || Auth::user()->hasRole('admin'))
                        <a href="{{ route('siswa.create') }}" 
                           class="mb-4 inline-block text-black border border-black p-2 rounded-lg hover:bg-black hover:text-white transition">
                            Tambah Data
                        </a>
                    @endif

                    {{-- Tabel Data Siswa --}}
                    <x-table>
                        <x-slot name="header">
                            <thead class="bg-gray-100 dark:bg-gray-700">
                                <tr>
                                    <th class="px-4 py-2">No</th>
                                    <th class="px-4 py-2">NIS</th>
                                    <th class="px-4 py-2">Nama</th>
                                    <th class="px-4 py-2">Kelas</th>
                                    <th class="px-4 py-2">Jurusan</th>
                                    <th class="px-4 py-2">Jenis Kelamin</th>
                                    <th class="px-4 py-2">No Telepon</th>
                                    <th class="px-4 py-2">Alamat</th>
                                    @if(!(auth()->user()->hasRole('siswa') || auth()->user()->hasRole('kepsek') || auth()->user()->hasRole('kajur')))
                                        <th class="px-4 py-2">Aksi</th>
                                    @endif
                                </tr>
                            </thead>
                        </x-slot>

                        <tbody>
                            @php $num = 1; @endphp
                            @foreach ($siswa as $data)
                                <tr class="border-b border-gray-200 dark:border-gray-700">
                                    <td class="px-4 py-2">{{ $num++ }}</td>
                                    <td class="px-4 py-2">{{ $data->nis }}</td>
                                    <td class="px-4 py-2">{{ $data->nama }}</td>
                                    <td class="px-4 py-2">{{ $data->kelas }}</td>
                                    <td class="px-4 py-2">{{ $data->jurusan }}</td>
                                    <td class="px-4 py-2">{{ $data->jenis_kelamin }}</td>
                                    <td class="px-4 py-2">{{ $data->no_tlp }}</td>
                                    <td class="px-4 py-2">{{ $data->alamat }}</td>

                                    @if (Auth::user()->hasRole('gurubk') || Auth::user()->hasRole('admin'))
                                        <td class="px-4 py-2 flex space-x-2">
                                            {{-- Tombol Edit --}}
                                            <a href="{{ route('siswa.edit', $data->id) }}"
                                               class="bg-blue-600 hover:bg-blue-800 text-white font-bold py-2 px-4 rounded">
                                                EDIT
                                            </a>

                                            {{-- Tombol Hapus --}}
                                            <button type="button"
                                                    class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#hapusModal_{{ $data->id }}">
                                                HAPUS
                                            </button>
                                        </td>
                                    @endif
                                </tr>
                            @endforeach
                        </tbody>
                    </x-table>

                    {{-- Pagination opsional --}}
                    {{-- <div class="mt-4">
                        {{ $siswa->links() }}
                    </div> --}}

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
