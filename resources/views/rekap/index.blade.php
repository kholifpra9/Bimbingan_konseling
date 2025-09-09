@include('rekap.delete')

<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
      {{ __('Data Rekap Bimbingan') }}
    </h2>
  </x-slot>

  <div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
      <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-lg sm:rounded-xl">

        {{-- Header card --}}
        <div class="px-6 py-5 flex items-center justify-between border-b border-gray-200 dark:border-gray-700">
          <div>
            <h3 class="text-lg font-semibold">Daftar Rekap Bimbingan</h3>
            <p class="text-sm text-gray-500 dark:text-gray-400">Ringkasan bimbingan siswa beserta status balasan.</p>
          </div>
          @hasrole('gurubk')
            <a href="{{ route('rekap.create') }}"
               class="inline-flex items-center gap-2 text-sm px-4 py-2 rounded-lg bg-blue-600 hover:bg-blue-700 text-white font-medium shadow">
              + Melakukan Bimbingan Konseling
            </a>
          @endhasrole
        </div>

        <div class="px-6 py-5">

          {{-- Toolbar (opsional search & filter; aman walau controller belum handle) --}}
          <div class="mb-4 flex flex-col gap-3 md:flex-row md:items-center md:justify-between">
            <form method="GET" action="{{ route('rekap.index') }}" class="flex flex-wrap gap-2">
              <input type="text" name="q" value="{{ request('q') }}"
                     placeholder="Cari nama / kelas / keterangan…"
                     class="w-64 rounded-lg border border-gray-300 dark:border-gray-600 text-black px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
              <select name="jenis" class="rounded-lg border border-gray-300 dark:border-gray-600 text-black px-3 py-2 bg-white">
                <option value="">Semua Jenis</option>
                <option value="Sosial"   {{ request('jenis')==='Sosial'?'selected':'' }}>Sosial</option>
                <option value="Akademik" {{ request('jenis')==='Akademik'?'selected':'' }}>Akademik</option>
                <option value="Pribadi"  {{ request('jenis')==='Pribadi'?'selected':'' }}>Pribadi</option>
              </select>
              <button class="px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 hover:bg-gray-100 dark:hover:bg-gray-700">
                Filter
              </button>
            </form>
          </div>

          <div class="overflow-x-auto">
            <table class="min-w-full border border-gray-200 dark:border-gray-700 rounded-lg overflow-hidden">
              <thead class="bg-gray-100 dark:bg-gray-700">
                <tr>
                  <th class="px-4 py-3 text-left text-xs font-semibold uppercase text-gray-600 dark:text-gray-300">No</th>
                  <th class="px-4 py-3 text-left text-xs font-semibold uppercase text-gray-600 dark:text-gray-300">Siswa</th>
                  <th class="px-4 py-3 text-left text-xs font-semibold uppercase text-gray-600 dark:text-gray-300">Jenis</th>
                  <th class="px-4 py-3 text-left text-xs font-semibold uppercase text-gray-600 dark:text-gray-300">Tanggal Bimbingan</th>
                  <th class="px-4 py-3 text-left text-xs font-semibold uppercase text-gray-600 dark:text-gray-300">Keterangan</th>
                  <th class="px-4 py-3 text-left text-xs font-semibold uppercase text-gray-600 dark:text-gray-300">Balasan</th>
                  <th class="px-4 py-3 text-left text-xs font-semibold uppercase text-gray-600 dark:text-gray-300">Status</th>
                  @hasrole('gurubk')
                    <th class="px-4 py-3 text-center text-xs font-semibold uppercase text-gray-600 dark:text-gray-300">Aksi</th>
                  @endhasrole
                </tr>
              </thead>

              <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                @forelse ($rekap as $i => $data)
                  @php
                    $jenis = $data->jenis_bimbingan;
                    $badge = match($jenis) {
                      'Sosial'   => 'bg-blue-100 text-blue-800',
                      'Akademik' => 'bg-emerald-100 text-emerald-800',
                      'Pribadi'  => 'bg-purple-100 text-purple-800',
                      default    => 'bg-gray-100 text-gray-800',
                    };
                    $tgl = $data->tgl_bimbingan ? \Carbon\Carbon::parse($data->tgl_bimbingan)->format('d M Y') : '-';
                    $balasanAda = filled($data->balasan);
                    $rowNumber = ($rekap instanceof \Illuminate\Pagination\AbstractPaginator)
                                 ? ($rekap->firstItem() + $i)
                                 : ($loop->iteration);
                  @endphp

                  <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50">
                    <td class="px-4 py-3 text-sm text-gray-500">{{ $rowNumber }}</td>

                    <td class="px-4 py-3">
                      <div class="font-medium">
                        {{ optional($data->siswa)->nama ?? 'Siswa tidak ditemukan' }}
                      </div>
                      <div class="text-xs text-gray-500">
                        {{ optional($data->siswa)->nis }} • {{ optional($data->siswa)->kelas }}
                      </div>
                    </td>

                    <td class="px-4 py-3 whitespace-nowrap">
                      <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-semibold {{ $badge }}">
                        {{ $jenis ?? '-' }}
                      </span>
                    </td>

                    <td class="px-4 py-3 whitespace-nowrap">{{ $tgl }}</td>

                    <td class="px-4 py-3">
                      <div class="max-w-[42ch] truncate" title="{{ $data->keterangan }}">
                        {{ $data->keterangan }}
                      </div>
                    </td>

                    <td class="px-4 py-3">
                      @if($balasanAda)
                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-semibold bg-green-100 text-green-800">
                          Dibalas
                        </span>
                        <div class="mt-1 max-w-[38ch] truncate text-sm text-gray-600 dark:text-gray-300" title="{{ $data->balasan }}">
                          {{ $data->balasan }}
                        </div>
                      @else
                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-semibold bg-gray-100 text-gray-700">
                          Belum dibalas
                        </span>
                      @endif
                    </td>
                    @php
                      $status = $data->status ?? 'proses';
                      $statusBadge = $status === 'selesai'
                          ? 'bg-green-100 text-green-800'
                          : 'bg-amber-100 text-amber-800';
                    @endphp

                    <td class="px-4 py-3 whitespace-nowrap">
                      <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-semibold {{ $statusBadge }}">
                        {{ ucfirst($status) }}
                      </span>
                    </td>

                    @hasrole('gurubk')
                       <td class="px-4 py-3 whitespace-nowrap">
                          @php $done = ($data->status ?? 'proses') === 'selesai'; @endphp

                          <div class="flex flex-wrap items-center gap-2">
                            {{-- Balas --}}
                            <a href="{{ route('rekap.edit', $data->id) }}"
                              class="inline-flex items-center h-9 px-3 rounded-md text-xs font-semibold leading-none
                                      bg-indigo-600 text-white hover:bg-indigo-700
                                      focus:outline-none focus:ring-2 focus:ring-indigo-500">
                              <svg class="w-4 h-4 mr-1.5 shrink-0 -mt-px" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                      d="M3 10h7l-1-1m1 1l-1 1M14 7h4a2 2 0 012 2v8a2 2 0 01-2 2h-9l-4-4V9a2 2 0 012-2h3"/>
                              </svg>
                              Balas
                            </a>

                            @if($done)
                              {{-- Badge selesai --}}
                              <span class="inline-flex items-center h-9 px-3 rounded-md text-xs font-semibold leading-none
                                          bg-green-100 text-green-800 ring-1 ring-inset ring-green-200">
                                <svg class="w-4 h-4 mr-1.5 shrink-0 -mt-px" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                  <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                                </svg>
                                Selesai
                              </span>
                            @else
                              {{-- Tandai selesai --}}
                              <form action="{{ route('rekap.selesai', $data->id) }}" method="POST"
                                    class="inline" x-data="{loading:false}"
                                    onsubmit="return confirm('Tandai bimbingan ini sudah selesai?');"
                                    @submit="loading = true">
                                @csrf
                                @method('PATCH')
                                <button type="submit"
                                        class="inline-flex items-center h-9 px-3 rounded-md text-xs font-semibold leading-none
                                              bg-emerald-600 text-white hover:bg-emerald-700
                                              focus:outline-none focus:ring-2 focus:ring-emerald-500
                                              disabled:opacity-60 disabled:cursor-not-allowed"
                                        :disabled="loading">
                                  <svg x-show="!loading" class="w-4 h-4 mr-1.5 shrink-0 -mt-px" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                                  </svg>
                                  <svg x-show="loading" class="w-4 h-4 mr-1.5 shrink-0 animate-spin" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="3"></circle>
                                    <path class="opacity-75" fill="currentColor"
                                          d="M4 12a8 8 0 018-8v3A5 5 0 007 12H4z"></path>
                                  </svg>
                                  Tandai Selesai
                                </button>
                              </form>
                            @endif
                          </div>
                        </td>

                    @endhasrole
                  </tr>
                @empty
                  <tr>
                    <td colspan="7" class="px-6 py-10 text-center text-gray-500 dark:text-gray-400">
                      Belum ada data rekap bimbingan.
                    </td>
                  </tr>
                @endforelse
              </tbody>
            </table>
          </div>

          {{-- Pagination (aman kalau $rekap bukan paginator, tidak akan dieksekusi) --}}
          @if($rekap instanceof \Illuminate\Pagination\AbstractPaginator)
            <div class="px-1 py-4">
              {{ $rekap->withQueryString()->links() }}
            </div>
          @endif

        </div>
      </div>
    </div>
  </div>
</x-app-layout>
