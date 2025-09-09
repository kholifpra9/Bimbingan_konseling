<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight text-center mx-auto">
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
           
            <div class="bg-gradient-to-r from-red-700 via-red-800 to-red-900 shadow-2xl rounded-lg overflow-hidden mb-10">
                <div class="p-8 text-white">
                    <h1 class="text-3xl font-extrabold mb-3">Selamat Datang di Aplikasi Bimbingan Konseling SMKN NEGERI 1 CILAKU</h1>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">

                {{-- Data Siswa — tampil untuk admin, gurubk, siswa (TIDAK untuk kajur) --}}
                @if(auth()->user()->hasRole('admin'))
                <div class="relative group">
                    <div class="absolute inset-0 bg-gradient-to-br from-blue-400 to-indigo-600 rounded-lg opacity-75 blur-lg group-hover:blur-none transition duration-500"></div>
                    <a href="{{ route('siswa.index') }}" class="relative block w-full h-56 bg-white dark:bg-gray-800 rounded-lg shadow-lg transform hover:scale-105 transition duration-300">
                        <div class="flex flex-col justify-center items-center h-full p-4">
                            <div class="mb-4 text-blue-500">
                                <svg class="w-16 h-16" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                    <path d="M12 12c3.86 0 7-3.14 7-7s-3.14-7-7-7-7 3.14-7 7 3.14 7 7 7z"></path>
                                    <path d="M4 22v-1c0-2.5 5-4 8-4s8 1.5 8 4v1"></path>
                                </svg>
                            </div>
                            <h3 class="text-2xl font-bold text-blue-600 dark:text-blue-400">Data Siswa</h3>
                            @if(auth()->user()->hasRole('admin') || auth()->user()->hasRole('gurubk'))
                                <p class="text-gray-700 dark:text-gray-300">Kelola data siswa</p>
                            @endif
                        </div>
                    </a>
                </div>
                @endif
               
                {{-- Data Guru BK — hanya admin (TIDAK untuk kajur) --}}
                @hasrole('admin')
                <div class="relative group">
                    <div class="absolute inset-0 bg-gradient-to-br from-blue-400 to-indigo-600 rounded-lg opacity-75 blur-lg group-hover:blur-none transition duration-500"></div>
                    <a href="{{ route('guru_bk.index') }}" class="relative block w-full h-56 bg-white dark:bg-gray-800 rounded-lg shadow-lg transform hover:scale-105 transition duration-300">
                        <div class="flex flex-col justify-center items-center h-full p-4">
                            <div class="mb-4 text-blue-500">
                                <svg class="w-16 h-16" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                    <path d="M12 12c3.86 0 7-3.14 7-7s-3.14-7-7-7-7 3.14-7 7 3.14 7 7 7z"></path>
                                    <path d="M4 22v-1c0-2.5 5-4 8-4s8 1.5 8 4v1"></path>
                                </svg>
                            </div>
                            <h3 class="text-2xl font-bold text-blue-600 dark:text-blue-400">Data Guru BK</h3>
                            <p class="text-gray-700 dark:text-gray-300">Kelola data guru bk</p>
                        </div>
                    </a>
                </div>
                @endhasrole
                
                {{-- Data Pelanggaran — gurubk & kajur (kajur HANYA lihat/akses ini) --}}
                @if(auth()->user()->hasRole('gurubk') || auth()->user()->hasRole('kajur') || auth()->user()->hasRole('kepsek') || auth()->user()->hasRole('kesiswaan')) 
                <div class="relative group">
                    <div class="absolute inset-0 bg-gradient-to-br from-red-400 to-red-500 rounded-lg opacity-75 blur-lg group-hover:blur-none transition duration-500"></div>
                    <a href="{{ route('pelanggaran.rekap') }}" class="relative block w-full h-56 bg-white dark:bg-gray-800 rounded-lg shadow-lg transform hover:scale-105 transition duration-300">
                        <div class="flex flex-col justify-center items-center h-full p-4">
                            <div class="mb-4 text-red-500">
                                <svg class="w-16 h-16" fill="#d02525" version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 469.548 469.548" xml:space="preserve"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <g> <g> <path d="M280.708,206.063c1.979,1.663,3.711,3.723,5.053,6.428l48.466-20.055c4.332-1.79,6.389-6.755,4.593-11.085L265.953,5.243 C264.602,1.978,261.437,0,258.111,0c-1.082,0-2.188,0.202-3.246,0.643L135.319,50.119c-4.326,1.785-6.388,6.75-4.59,11.081 l56.37,136.229c-3.737,3.791-8.023,8.275-13.425,13.804c-19.969,20.419-19.586,32.666-25.183,67.21 c-3.731,22.999-13.739,31.094-9.073,44.728c3.036,8.219,7.935,14.358,11.379,18.001c0.523,0.537,0.96,0.994,1.401,1.423 c1.286,1.258,2.15,1.996,2.394,2.196c0.722,0.717,1.427,1.422,2.212,2.191l-0.008,0.009l2.661,2.604l1.429,1.395l2.645,2.601 l1.422,1.395l1.431,1.395l-0.034,0.061c31.106,30.989,34.919,37.613,56.908,62.184c23.412,26.148,33.586,50.926,33.586,50.926 s75.853-25.367,68.223-38.179c-7.635-12.815-10.243-31.907-10.243-31.907c-2.421-44.787-37.65-101.027-35.041-101.027 c0.185,0,0.557,0.276,1.15,0.861c5.205,5.19,8.836,8.02,13.068,8.02c2.997,0,6.287-1.427,10.644-4.44 c10.487-7.253-10.411-29.731-10.411-29.731s4.812-1.302,11.221-10.892c6.403-9.598-32.974-30.038-32.974-30.038 s16.799-3.4,9.906-17.783c-0.076-0.165-0.16-0.283-0.244-0.437c-1.555-3.069-3.467-5.025-5.507-6.235 c-2.412-1.427-5.005-1.859-7.441-1.859c-3.13,0-5.979,0.659-7.851,0.659c-0.958,0-1.655-0.172-1.995-0.697 c-1.944-3.072-4.941-11.313-4.941-11.313c-5.391-14.792-11.786-18.755-17.098-18.755c-6.113,0-10.786,5.26-10.786,5.26 s-17.985,11.475-8.849,51.081c0.059,0.23,0.08,0.433,0.134,0.667c0.591,2.499,1.132,4.885,1.611,7.157 c7.276,34.22,2.748,43.053,2.748,43.053c-3.196,2.744-6.156,3.843-8.838,3.843c-5.601,0-9.993-4.733-12.83-8.977 c-0.28-0.846-0.549-1.735-0.801-2.642c-0.227-0.809-0.437-1.654-0.637-2.496c-2.981-12.68-3.522-29.21-3.561-30.545l1.396-2.023 c1.407-2.897,3.1-5.274,4.829-7.41l1.875,4.544c1.348,3.266,4.514,5.241,7.842,5.241c1.084,0,2.184-0.212,3.242-0.641l1.02-0.433 c-0.517-2.469-1.074-5.021-1.725-7.777c0-0.014-0.008-0.03-0.008-0.038l-2.529,1.042c-0.046,0-0.431-0.006-0.587-0.391l-3.07-7.42 h-0.008l-0.637-1.537l-1.185-2.875L193.202,191.5c-0.016,0.016-0.036,0.024-0.044,0.04L137.98,58.193 c-0.134-0.32,0.024-0.689,0.345-0.823L257.87,7.896c0.085-0.032,0.161-0.046,0.245-0.046c0.048,0,0.433,0.006,0.593,0.395 l72.875,176.104c0.132,0.322-0.024,0.689-0.345,0.823L280.708,206.063z"></path> <path d="M211.57,203.691c-0.081,0.096-0.119,0.222-0.205,0.307c0.032,0.142,0.062,0.471,0.1,0.881 C211.508,204.493,211.524,204.078,211.57,203.691z"></path> <path d="M220.769,181.021c0.277-0.307,0.533-0.581,0.793-0.84c-0.172,0.108-0.336,0.227-0.509,0.339 c-0.032,0.052-0.032,0.102-0.054,0.164C220.927,180.785,220.835,180.903,220.769,181.021z"></path> <path d="M238.042,164.685c2.328,3.062,5.706,4.875,9.474,5.093c0.244,0.016,0.473,0.12,0.733,0.12 c1.727,0,3.434-0.347,5.105-1.036c7.017-2.897,9.922-10.269,6.916-17.524c-2.945-7.089-10.362-10.361-17.271-7.514 c-3.362,1.391-5.915,3.959-7.18,7.226c-1.238,3.208-1.146,6.869,0.274,10.293C236.605,162.581,237.28,163.689,238.042,164.685z"></path> <polygon points="249.59,135.981 220.32,58.973 199.089,67.755 232.797,142.931 "></polygon> </g> </g> </g></svg>
                            </div>
                            <h3 class="text-2xl font-bold text-red-600 dark:text-red-400">Data Pelanggaran</h3>
                            <p class="text-gray-700 dark:text-gray-300">Mengelola data pelanggaran</p>
                        </div>
                    </a>
                </div>
                @endif

                {{-- Rekap Bimbingan — hanya gurubk (TIDAK untuk kajur) --}}
                @hasrole('gurubk')
                <div class="relative group">
                    <div class="absolute inset-0 bg-gradient-to-br from-red-400 to-pink-500 rounded-lg opacity-75 blur-lg group-hover:blur-none transition duration-500"></div>
                    <a href="{{ route('rekap.index') }}" class="relative block w-full h-56 bg-white dark:bg-gray-800 rounded-lg shadow-lg transform hover:scale-105 transition duration-300">
                        <div class="flex flex-col justify-center items-center h-full p-4">
                            <div class="mb-4 text-red-500">
                                <svg class="w-16 h-16" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                    <path d="M5 13l4 4L19 7"></path>
                                </svg>
                            </div>
                            <h3 class="text-2xl font-bold text-red-600 dark:text-red-400">Rekap Bimbingan</h3>
                            <p class="text-gray-700 dark:text-gray-300">Mengelola Rekap Bimbingan</p>
                        </div>
                    </a>
                </div>
                @endhasrole

                {{-- Daftar Curhat — hanya gurubk (TIDAK untuk kajur) --}}
                @hasrole('gurubk')
                <div class="relative group">
                    <div class="absolute inset-0 bg-gradient-to-br from-purple-400 to-indigo-500 rounded-lg opacity-75 blur-lg group-hover:blur-none transition duration-500"></div>
                    <a href="{{ route('gurubk.curhat') }}" class="relative block w-full h-56 bg-white dark:bg-gray-800 rounded-lg shadow-lg transform hover:scale-105 transition duration-300">
                        <div class="flex flex-col justify-center items-center h-full p-4">
                            <div class="mb-4 text-purple-500">
                                <svg class="w-16 h-16" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                    <path d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                                </svg>
                            </div>
                            <h3 class="text-2xl font-bold text-purple-600 dark:text-purple-400">Daftar Curhat</h3>
                            <p class="text-gray-700 dark:text-gray-300">Lihat curhat rahasia siswa</p>
                        </div>
                    </a>
                </div>
                @endhasrole

                <!-- {{-- Bimbingan Lanjutan — hanya gurubk (TIDAK untuk kajur) --}}
                @hasrole('gurubk')
                <div class="relative group">
                    <div class="absolute inset-0 bg-gradient-to-br from-orange-400 to-red-500 rounded-lg opacity-75 blur-lg group-hover:blur-none transition duration-500"></div>
                    <a href="{{ route('gurubk.bimbingan-lanjutan') }}" class="relative block w-full h-56 bg-white dark:bg-gray-800 rounded-lg shadow-lg transform hover:scale-105 transition duration-300">
                        <div class="flex flex-col justify-center items-center h-full p-4">
                            <div class="mb-4 text-orange-500">
                                <svg class="w-16 h-16" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                    <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <h3 class="text-2xl font-bold text-orange-600 dark:text-orange-400">Bimbingan Lanjutan</h3>
                            <p class="text-gray-700 dark:text-gray-300">Kelola bimbingan lanjutan siswa</p>
                        </div>
                    </a>
                </div>
                @endhasrole -->

                {{-- Daftar Cek Masalah — hanya gurubk (TIDAK untuk kajur) --}}
                @hasrole('gurubk')
                <div class="relative group">
                    <div class="absolute inset-0 bg-gradient-to-br from-teal-400 to-cyan-500 rounded-lg opacity-75 blur-lg group-hover:blur-none transition duration-500"></div>
                    <a href="{{ route('gurubk.daftar-cek-masalah') }}" class="relative block w-full h-56 bg-white dark:bg-gray-800 rounded-lg shadow-lg transform hover:scale-105 transition duration-300">
                        <div class="flex flex-col justify-center items-center h-full p-4">
                            <div class="mb-4 text-teal-500">
                                <svg class="w-16 h-16" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                    <path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path>
                                </svg>
                            </div>
                            <h3 class="text-2xl font-bold text-teal-600 dark:text-teal-400">Daftar Cek Masalah</h3>
                            <p class="text-gray-700 dark:text-gray-300">Identifikasi masalah siswa</p>
                        </div>
                    </a>
                </div>
                @endhasrole

                {{-- Pengaduan — hanya siswa, admin, gurubk (TIDAK untuk kajur) --}}
                @if(auth()->user()->hasRole('siswa') || auth()->user()->hasRole('admin') || auth()->user()->hasRole('gurubk'))
                <div class="relative group">
                    <div class="absolute inset-0 bg-gradient-to-br from-green-400 to-teal-500 rounded-lg opacity-75 blur-lg group-hover:blur-none transition duration-500"></div>
                    <a 
                        @if(auth()->user()->hasRole('siswa'))
                            x-data=""
                            x-on:click.prevent="$dispatch('open-modal', 'pilihan'); $dispatch('pilihan')"
                            class="relative block w-full h-56 bg-white dark:bg-gray-800 rounded-lg shadow-lg transform hover:scale-105 transition duration-300"
                        @else
                            href="{{ route('pengaduan.index') }}"
                            class="relative block w-full h-56 bg-white dark:bg-gray-800 rounded-lg shadow-lg transform hover:scale-105 transition duration-300"
                        @endif
                    >
                        <div class="flex flex-col justify-center items-center h-full p-4">
                            <div class="mb-4 text-green-500">
                                <svg class="w-16 h-16"  fill="#2ab620" height="200px" width="200px" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 496 496" xml:space="preserve" stroke="#2ab620"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <g> <g> <g> <path d="M496,168.648V64c0-35.288-28.712-64-64-64h-48c-35.288,0-64,28.712-64,64c0,0.456,0.056,0.904,0.072,1.36 C304.896,59.224,288.584,56,272.144,56h-48.28c-16.448,0-32.76,3.224-47.928,9.36C175.944,64.904,176,64.456,176,64 c0-35.288-28.712-64-64-64H64C28.712,0,0,28.712,0,64v104.648L50.808,128h58.184C100.504,145.376,96,164.4,96,183.856 c0,19.504,4.576,38.632,13.2,56.144H64c-35.288,0-64,28.712-64,64v104.648L50.808,368H112c19.72,0,37.368-8.976,49.12-23.04 c6.304,9.68,14.056,18.072,22.88,25.008V392l-49.872,14.976C96.968,418.416,72,452.208,72,491.088V496h16v-4.912 c0-31.808,20.432-59.464,50.832-68.816l10.144-3.12l-6.4,25.584l100.464,41.856l4.96,6.216l4.968-6.208l100.464-41.856 l-6.4-25.584l10.152,3.12c30.392,9.344,50.816,37,50.816,68.808V496h16v-4.912c0-38.872-24.96-72.672-62.12-84.112 l-47.528-14.624L312,392.304V369.96c8.824-6.928,16.576-15.328,22.88-25.008C346.632,359.024,364.28,368,384,368h61.192 L496,408.648V304c0-35.288-28.712-64-64-64h-45.2c8.624-17.512,13.2-36.632,13.2-56.144c0-19.456-4.504-38.48-12.992-55.856 h58.184L496,168.648z M223.856,72h48.28c17.888,0,35.528,4.464,51.352,12.68c6.88,20.056,23.432,35.608,44.08,41.104 c10.72,17.56,16.432,37.552,16.432,58.072c0,20.584-5.816,40.704-16.72,58.432c-5.416,1.472-10.536,3.616-15.28,6.368V224 c0-30.872-25.128-56-56-56h-96c-30.872,0-56,25.128-56,56v24.656c-4.744-2.752-9.872-4.896-15.28-6.368 C117.816,224.56,112,204.44,112,183.856c0-20.528,5.712-40.52,16.424-58.072c20.656-5.496,37.208-21.048,44.08-41.104 C188.328,76.464,205.976,72,223.856,72z M45.192,112L16,135.352V64c0-26.472,21.528-48,48-48h48c26.472,0,48,21.528,48,48 s-21.528,48-48,48H45.192z M112,352H45.192L16,375.352V304c0-26.472,21.528-48,48-48h48c26.472,0,48,21.528,48,48 S138.472,352,112,352z M161.432,435.264l5.4-21.608l14.32-4.408L222.24,460.6L161.432,435.264z M248,467.2l-48-60.008V400v-8 v-11.688C214.496,387.856,230.848,392,248,392s33.504-4.144,48-11.688V392v8v7.192L248,467.2z M314.848,409.248l14.32,4.408 l5.4,21.608L273.76,460.6L314.848,409.248z M325.312,329.464C309.912,358.192,280.704,376,248,376 c-32.704,0-61.912-17.808-77.312-46.536c3.4-7.816,5.312-16.416,5.312-25.464c0-16.168-6.072-30.912-16-42.192V224 c0-22.056,17.944-40,40-40h96c22.056,0,40,17.944,40,40v37.808c-9.928,11.28-16,26.024-16,42.192 C320,313.048,321.912,321.648,325.312,329.464z M432,256c26.472,0,48,21.528,48,48v71.352L450.808,352H384 c-26.472,0-48-21.528-48-48s21.528-48,48-48H432z M384,112c-26.472,0-48-21.528-48-48s21.528-48,48-48h48 c26.472,0,48,21.528,48,48v71.352L450.808,112H384z"></path> <path d="M248,304c-22.056,0-40,17.944-40,40h16c0-13.232,10.768-24,24-24s24,10.768,24,24h16C288,321.944,270.056,304,248,304z"></path> <path d="M224,252c0-8.048-4.8-14.96-11.672-18.128l17.136,5.712l5.064-15.168l-48-16l-5.064,15.168l26.424,8.808 C206.632,232.144,205.336,232,204,232c-11.032,0-20,8.968-20,20s8.968,20,20,20S224,263.032,224,252z M204,256c-2.2,0-4-1.8-4-4 s1.8-4,4-4s4,1.8,4,4S206.2,256,204,256z"></path> <path d="M309.472,208.416l-48,16l5.064,15.168l17.136-5.712C276.8,237.04,272,243.952,272,252c0,11.032,8.968,20,20,20 c11.032,0,20-8.968,20-20c0-11.032-8.968-20-20-20c-1.336,0-2.632,0.144-3.888,0.392l26.424-8.808L309.472,208.416z M292,248 c2.2,0,4,1.8,4,4s-1.8,4-4,4s-4-1.8-4-4S289.8,248,292,248z"></path> </g> </g> </g> </g></svg>
                            </div>
                            <center>
                            @if(auth()->user()->hasRole('admin') || auth()->user()->hasRole('gurubk'))
                                <h3 class="text-2xl font-bold text-green-600 dark:text-green-400">Pengaduan</h3>
                            @else
                                <h3 class="text-2xl font-bold text-green-600 dark:text-green-400">Pengaduan & Bimbingan Konseling</h3>
                            @endif
                            </center>
                            
                            @if(auth()->user()->hasRole('admin') || auth()->user()->hasRole('gurubk'))
                                <p class="text-gray-700 dark:text-gray-300">Mengelola data pengaduan</p>
                            @endif
                        </div>
                    </a>
                </div>
                @endif

                {{-- Section khusus siswa (hasil bimbingan & isi cek masalah) — TIDAK untuk kajur --}}
                @hasrole('siswa')
                <div class="relative group">
                    <div class="absolute inset-0 bg-gradient-to-br from-red-400 to-pink-500 rounded-lg opacity-75 blur-lg group-hover:blur-none transition duration-500"></div>
                    <a href="{{ route('rekap.index') }}" class="relative block w-full h-56 bg-white dark:bg-gray-800 rounded-lg shadow-lg transform hover:scale-105 transition duration-300">
                        <div class="flex flex-col justify-center items-center h-full p-4">
                            <div class="mb-4 text-red-500">
                                <svg class="w-16 h-16" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                    <path d="M5 13l4 4L19 7"></path>
                                </svg>
                            </div>
                            <h3 class="text-2xl font-bold text-red-600 dark:text-red-400">Hasil Bimbingan Konseling</h3>
                        </div>
                    </a>
                </div>

                <div class="relative group">
                    <div class="absolute inset-0 bg-gradient-to-br from-teal-400 to-cyan-500 rounded-lg opacity-75 blur-lg group-hover:blur-none transition duration-500"></div>
                    <a href="{{ route('siswa.cek-masalah.create') }}" class="relative block w-full h-56 bg-white dark:bg-gray-800 rounded-lg shadow-lg transform hover:scale-105 transition duration-300">
                        <div class="flex flex-col justify-center items-center h-full p-4">
                            <div class="mb-4 text-teal-500">
                                <svg class="w-16 h-16" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                    <path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path>
                                </svg>
                            </div>
                            <h3 class="text-2xl font-bold text-teal-600 dark:text-teal-400">Isi Formulir Cek Masalah</h3>
                            <p class="text-gray-700 dark:text-gray-300 text-center">Identifikasi masalah yang Anda hadapi</p>
                        </div>
                    </a>
                </div>
                @endhasrole

            </div>
        </div>
    </div>
</x-app-layout>

<x-modal name="pilihan" focusable maxWidth="4xl">
    <div class="p-8 bg-gradient-to-br from-gray-50 to-gray-100 dark:from-gray-800 dark:to-gray-900">
        <!-- Header dengan gradient -->
        <div class="text-center mb-8">
            <h2 class="text-3xl font-bold bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent">
                Pilih Layanan Konseling
            </h2>
            <p class="text-gray-600 dark:text-gray-400 mt-2">Silakan pilih layanan yang Anda butuhkan</p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <!-- Pengaduan Card -->
            <div class="group relative">
                <div class="absolute -inset-0.5 bg-gradient-to-r from-blue-600 to-cyan-600 rounded-2xl blur opacity-30 group-hover:opacity-100 transition duration-1000 group-hover:duration-200"></div>
                <a href="{{ route('pengaduan.index') }}" class="relative block p-6 bg-white dark:bg-gray-800 rounded-2xl shadow-xl transform transition duration-300 hover:scale-105">
                    <div class="flex flex-col items-center">
                        <div class="w-20 h-20 bg-gradient-to-br from-blue-500 to-blue-600 rounded-full flex items-center justify-center mb-4 shadow-lg">
                            <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-800 dark:text-white mb-2">Pengaduan</h3>
                        <p class="text-sm text-gray-600 dark:text-gray-300 text-center">Laporkan masalah atau keluhan yang Anda alami</p>
                    </div>
                </a>
            </div>

            <!-- Bimbingan Konseling Card -->
            <div class="group relative">
                <div class="absolute -inset-0.5 bg-gradient-to-r from-green-600 to-emerald-600 rounded-2xl blur opacity-30 group-hover:opacity-100 transition duration-1000 group-hover:duration-200"></div>
                <a href="{{ route('rekap.create') }}" class="relative block p-6 bg-white dark:bg-gray-800 rounded-2xl shadow-xl transform transition duration-300 hover:scale-105">
                    <div class="flex flex-col items-center">
                        <div class="w-20 h-20 bg-gradient-to-br from-green-500 to-green-600 rounded-full flex items-center justify-center mb-4 shadow-lg">
                            <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-800 dark:text-white mb-2">Bimbingan Konseling</h3>
                        <p class="text-sm text-gray-600 dark:text-gray-300 text-center">Konsultasi langsung dengan Guru BK</p>
                    </div>
                </a>
            </div>

            <!-- Curhat Rahasia Card -->
            <div class="group relative">
                <div class="absolute -inset-0.5 bg-gradient-to-r from-purple-600 to-pink-600 rounded-2xl blur opacity-30 group-hover:opacity-100 transition duration-1000 group-hover:duration-200"></div>
                <a href="{{ route('konsultasi.create') }}" class="relative block p-6 bg-white dark:bg-gray-800 rounded-2xl shadow-xl transform transition duration-300 hover:scale-105">
                    <div class="flex flex-col items-center">
                        <div class="w-20 h-20 bg-gradient-to-br from-white-500 to-white-600 rounded-full flex items-center justify-center mb-4 shadow-lg">
                           
                            <svg class="w-10 h-10" height="200px" width="200px" version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 502.664 502.664" xml:space="preserve" fill="#2071d9" stroke="#2071d9"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <g> <g> <g> <path style="fill:#7a4ea6;" d="M374.404,214.834l128.238-109.062V75.767H0v30.048l128.217,109.062 c4.314,3.581-81.753-50.044-128.217-79.014v291.033h502.664V135.842C456.179,164.812,370.133,218.437,374.404,214.834z M173.515,189.122c0-42.861,34.945-77.741,77.849-77.741c42.796,0,77.72,34.858,77.72,77.741v45.148h-29.315v-45.148 c0-26.705-21.765-48.534-48.362-48.534c-26.748,0-48.534,21.83-48.534,48.534v45.148h-29.336L173.515,189.122L173.515,189.122z M345.78,384.92H156.863V247.751H345.78V384.92z"></path> <path style="fill:#7a4ea6;" d="M241.981,309.012L237.99,348.4h26.597l-4.055-39.388c5.004-3.128,8.305-8.628,8.305-14.862 c0-9.707-7.873-17.537-17.472-17.537c-9.793,0-17.58,7.83-17.58,17.537C233.806,300.384,237.106,305.906,241.981,309.012z"></path> </g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> </g> </g></svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-800 dark:text-white mb-2">Curhat Rahasia</h3>
                        <p class="text-sm text-gray-600 dark:text-gray-300 text-center">Ceritakan masalah pribadi dengan aman dan rahasia</p>
                    </div>
                </a>
            </div>
        </div>

        <!-- Footer dengan tombol tutup yang lebih menarik -->
        <div class="flex justify-center">
            <button x-on:click="$dispatch('close')" 
                    class="px-6 py-3 bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-full font-semibold hover:bg-gray-300 dark:hover:bg-gray-600 transition duration-200 transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-gray-400">
                <span class="flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                    Tutup
                </span>
            </button>
        </div>
    </div>
</x-modal>
