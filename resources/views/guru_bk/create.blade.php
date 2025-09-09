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
                    <form action="{{ route('guru_bk.store') }}" method="POST">
                        @csrf

                        <a href="{{ route('guru_bk.index') }}">Kembali</a>

                        @if ($errors->any())
                        <div class="mb-4 text-red-600">
                            <ul>
                                @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                        @endif

                        <div class="grid grid-cols-1 gap-4 mb-4">
                            <div>
                                <label for="nip" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                    Nip:
                                </label>
                                <input
                                    type="text"
                                    id="nip"
                                    name="nip"
                                    class="mt-1 block w-full rounded-md text-black"
                                    required />
                            </div>

                            <div>
                                <label for="nama" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                    Nama:
                                </label>
                                <input
                                    type="text"
                                    id="nama"
                                    name="nama"
                                    class="mt-1 block w-full rounded-md text-black"
                                    required />
                            </div>

                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                    Email:
                                </label>
                                <input
                                    type="text"
                                    id="email"
                                    name="email"
                                    class="mt-1 block w-full rounded-md text-black"
                                    required />
                            </div>

                            <div>
                                <label for="jenis_kelamin" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                    Jenis Kelamin:
                                </label>
                                <input
                                    type="text"
                                    id="jenis_kelamin"
                                    name="jenis_kelamin"
                                    class="mt-1 block w-full rounded-md text-black"
                                    required />
                            </div>

                            <div>
                                <label for="no_tlp" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                    Nomor HP:
                                </label>
                                <input
                                    type="text"
                                    id="no_tlp"
                                    name="no_tlp"
                                    class="mt-1 block w-full rounded-md text-black"
                                    required />
                            </div>

                            <div>
                                <label for="alamat" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                    Alamat:
                                </label>
                                <input
                                    type="text"
                                    id="alamat"
                                    name="alamat"
                                    class="mt-1 block w-full rounded-md text-black"
                                    required />
                            </div>
                            <button value="true"type="submit"name=save>
                                simpan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>