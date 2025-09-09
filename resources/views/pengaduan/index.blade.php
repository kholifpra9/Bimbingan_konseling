<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
      {{ __('Data Pengaduan') }}
    </h2>
  </x-slot>

  <div class="py-12">
    <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">

      <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-lg sm:rounded-xl">
        <div class="px-6 pt-6 pb-4 border-b border-gray-200 dark:border-gray-700">
          <div class="flex items-center justify-between">
            <div>
              <h3 class="text-lg font-semibold">Pengaduan Siswa</h3>
              <p class="text-sm text-gray-500 dark:text-gray-400">Laporkan kejadian secara jelas dan sopan.</p>
            </div>

            {{-- Tombol buka modal hanya untuk siswa --}}
            @hasrole('siswa')
            <div
              x-data="{
                open: {{ $errors->any() ? 'true':'false' }},
                body: @js(old('laporan_pengaduan','')),
                maxBody: 1000,
                imgUrl: null,
                onFileChange(e){
                  const f = e.target.files?.[0];
                  if(!f){ this.imgUrl = null; return; }
                  this.imgUrl = URL.createObjectURL(f);
                }
              }"
              x-id="['modal-title']"
              class="relative"
            >
              <button @click="open=true"
                      class="inline-flex items-center gap-2 text-sm px-4 py-2 rounded-lg bg-blue-600 hover:bg-blue-700 text-white font-medium shadow">
                + Buat Pengaduan
              </button>

              {{-- MODAL --}}
              <div
                x-show="open"
                x-transition.opacity
                x-cloak
                class="fixed inset-0 z-50"
                aria-modal="true"
                role="dialog"
                @keydown.escape.window="open=false"
              >
                {{-- overlay --}}
                <div class="absolute inset-0 bg-black/50"></div>

                {{-- panel --}}
                <div class="absolute inset-0 flex items-center justify-center p-4">
                  <div
                    x-show="open"
                    x-transition
                    @click.outside="open=false"
                    class="w-full max-w-3xl bg-white dark:bg-gray-800 rounded-xl shadow-2xl overflow-hidden"
                  >
                    {{-- header modal --}}
                    <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 flex items-center justify-between">
                      <h2 :id="$id('modal-title')" class="text-lg font-semibold">Buat Pengaduan</h2>
                      <button @click="open=false"
                              class="rounded-lg p-2 hover:bg-gray-100 dark:hover:bg-gray-700"
                              aria-label="Tutup">
                        ✕
                      </button>
                    </div>

                    {{-- body modal (form) --}}
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                      <form method="POST" action="{{ route('pengaduan.store') }}" enctype="multipart/form-data" class="space-y-6" novalidate>
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

                        {{-- Data Pengadu --}}
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                          {{-- NIS (dikunci untuk siswa yang punya relasi) --}}
                          <div>
                            <label class="block text-sm font-medium mb-1">NIS</label>
                            @php $nisAuth = optional(Auth::user()->siswa ?? null)->nis; @endphp
                            @if($nisAuth)
                              <input type="text" value="{{ $nisAuth }}"
                                     class="w-full rounded-lg border border-gray-300 dark:border-gray-600 text-black px-3 py-2 bg-gray-50 dark:bg-gray-900" readonly>
                              <input type="hidden" name="nis" value="{{ $nisAuth }}">
                            @else
                              <input type="text" name="nis" value="{{ old('nis') }}"
                                     class="w-full rounded-lg border border-gray-300 dark:border-gray-600 text-black px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                     required aria-required="true" placeholder="Masukkan NIS">
                            @endif
                            @error('nis') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                          </div>

                          {{-- Tanggal --}}
                          <div>
                            <label for="tgl_pengaduan" class="block text-sm font-medium mb-1">Tanggal Pengaduan</label>
                            <input type="date" id="tgl_pengaduan" name="tgl_pengaduan"
                                   value="{{ old('tgl_pengaduan', now()->toDateString()) }}"
                                   class="w-full rounded-lg border border-gray-300 dark:border-gray-600 text-black px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                   required aria-required="true">
                            @error('tgl_pengaduan') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                          </div>
                        </div>

                        {{-- Isi Laporan --}}
                        <div>
                          <div class="flex items-center justify-between">
                            <label for="laporan_pengaduan" class="block text-sm font-medium mb-1">Laporan Pengaduan</label>
                            <span class="text-xs text-gray-500" x-text="`${body.length}/${maxBody}`"></span>
                          </div>
                          <textarea id="laporan_pengaduan" name="laporan_pengaduan" rows="5"
                                    x-model="body" maxlength="1000"
                                    class="w-full rounded-lg border border-gray-300 dark:border-gray-600 text-black px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                    placeholder="Ceritakan kronologi, tempat, waktu, dan pihak yang terlibat dengan jelas..."
                                    required aria-required="true">{{ old('laporan_pengaduan') }}</textarea>
                          @error('laporan_pengaduan') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                          {{-- Jenis Pengaduan --}}
                          <div class="md:col-span-2">
                            <label for="jenis_pengaduan" class="block text-sm font-medium mb-1">Jenis Pengaduan</label>
                            <select id="jenis_pengaduan" name="jenis_pengaduan"
                                    class="w-full rounded-lg border border-gray-300 dark:border-gray-600 text-black px-3 py-2 bg-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                    required aria-required="true">
                              <option value="" disabled {{ old('jenis_pengaduan') ? '' : 'selected' }}>Pilih Jenis Pengaduan</option>
                              <option value="bullyng"         {{ old('jenis_pengaduan')==='bullyng' ? 'selected' : '' }}>Bullying</option>
                              <option value="kenakalanremaja" {{ old('jenis_pengaduan')==='kenakalanremaja' ? 'selected' : '' }}>Kenakalan Remaja</option>
                            </select>
                            @error('jenis_pengaduan') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                          </div>

                          {{-- Lampiran Gambar (opsional) --}}
                          <div>
                            <label for="gambar" class="block text-sm font-medium mb-1">Lampiran Gambar (opsional)</label>
                            <input type="file" id="gambar" name="gambar" accept="image/*"
                                   @change="onFileChange($event)"
                                   class="block w-full text-sm text-gray-700 file:mr-3 file:py-2 file:px-3
                                          file:rounded-lg file:border-0 file:bg-gray-100 file:text-gray-700
                                          hover:file:bg-gray-200 rounded-lg border border-gray-300 dark:border-gray-600">
                            @error('gambar') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror

                            {{-- Preview --}}
                            <template x-if="imgUrl">
                              <img :src="imgUrl" alt="Preview" class="mt-2 h-28 w-28 object-cover rounded-lg border border-gray-200">
                            </template>
                          </div>
                        </div>

                        {{-- Actions modal --}}
                        <div class="flex items-center justify-end gap-3 pt-2">
                          <button type="button"
                                  @click="open=false"
                                  class="px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 hover:bg-gray-100 dark:hover:bg-gray-700">
                            Batal
                          </button>
                          <button type="submit" name="save" value="true"
                                  class="inline-flex items-center px-5 py-2.5 rounded-lg bg-blue-600 hover:bg-blue-700 text-white font-medium shadow">
                            Kirim
                          </button>
                        </div>
                      </form>
                    </div>

                  </div>
                </div>
              </div> {{-- /MODAL --}}
            </div>
            @endhasrole
          </div>
        </div>

        {{-- LIST PENGADUAN (semua role yang diizinkan menonton daftar) --}}
        @role('gurubk|admin|siswa')
        <div class="p-6">
          <div class="mb-3">
            <h4 class="text-sm font-semibold text-gray-700 dark:text-gray-200">Daftar Pengaduan</h4>
            <p class="text-xs text-gray-500 dark:text-gray-400">Pengaduan terbaru ditampilkan di atas.</p>
          </div>

          <div class="overflow-x-auto">
            <table class="min-w-full border border-gray-200 dark:border-gray-700 rounded-lg overflow-hidden">
              <thead class="bg-gray-100 dark:bg-gray-700">
                <tr>
                    <th class="px-4 py-3 text-left text-xs font-semibold uppercase text-gray-600 dark:text-gray-300">No</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold uppercase text-gray-600 dark:text-gray-300">NIS</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold uppercase text-gray-600 dark:text-gray-300">Tanggal</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold uppercase text-gray-600 dark:text-gray-300">Laporan</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold uppercase text-gray-600 dark:text-gray-300">Jenis</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold uppercase text-gray-600 dark:text-gray-300">Gambar</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold uppercase text-gray-600 dark:text-gray-300">Status</th>
                    @role('gurubk')
                    <th class="px-4 py-3 text-center text-xs font-semibold uppercase text-gray-600 dark:text-gray-300">Aksi</th>
                    @endrole
                    @role('admin')
                    <th class="px-4 py-3 text-center text-xs font-semibold uppercase text-gray-600 dark:text-gray-300">Admin</th>
                    @endrole
                </tr>
                </thead>

                <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                @php $num = 1; @endphp
                @forelse ($pengaduan as $data)
                    @php
                    $tglDisp = $data->tgl_pengaduan ? \Carbon\Carbon::parse($data->tgl_pengaduan)->format('d M Y') : '-';
                    $jenisBadge = match($data->jenis_pengaduan) {
                        'bullyng' => 'bg-red-100 text-red-800',
                        'kenakalanremaja' => 'bg-amber-100 text-amber-800',
                        default => 'bg-gray-100 text-gray-800',
                    };
                    $imgPath = $data->gambar;
                    $imgUrl  = $imgPath
                        ? (\Illuminate\Support\Str::contains($imgPath, '/')
                            ? \Illuminate\Support\Facades\Storage::url($imgPath)
                            : asset('storage/images/'.$imgPath))
                        : null;

                    $sudahDitinjau = ($data->status ?? 'baru') === 'ditinjau';
                    $statusBadge = $sudahDitinjau
                        ? 'bg-green-100 text-green-800 ring-1 ring-inset ring-green-200'
                        : 'bg-gray-100 text-gray-700 ring-1 ring-inset ring-gray-200';
                    $statusText = $sudahDitinjau ? 'Ditinjau' : 'Belum Ditinjau';
                    @endphp

                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50">
                    <td class="px-4 py-3 text-sm text-gray-500">{{ $num++ }}</td>
                    <td class="px-4 py-3">{{ $data->nis }}</td>
                    <td class="px-4 py-3 whitespace-nowrap">{{ $tglDisp }}</td>
                    <td class="px-4 py-3">
                        <div class="max-w-[48ch] truncate" title="{{ $data->laporan_pengaduan }}">
                        {{ $data->laporan_pengaduan }}
                        </div>
                    </td>
                    <td class="px-4 py-3 whitespace-nowrap">
                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-semibold {{ $jenisBadge }}">
                        {{ $data->jenis_pengaduan }}
                        </span>
                    </td>
                    <td class="px-4 py-3">
                        @if($imgUrl)
                        <a href="{{ $imgUrl }}" target="_blank" class="inline-block">
                            <img src="{{ $imgUrl }}" alt="lampiran" class="h-16 w-16 object-cover rounded border border-gray-200">
                        </a>
                        @else
                        <span class="text-sm text-gray-500">—</span>
                        @endif
                    </td>

                    {{-- Status --}}
                    <td class="px-4 py-3 whitespace-nowrap">
                        <span class="inline-flex items-center h-9 px-3 rounded-md text-xs font-semibold leading-none {{ $statusBadge }}">
                        {{ $statusText }}
                        </span>
                    </td>

                    {{-- Aksi Guru BK: Tandai Ditinjau --}}
                    @role('gurubk')
                    <td class="px-4 py-3 whitespace-nowrap">
                        <div class="flex items-center gap-2">
                        @php
                        $sudahDitinjau = ($data->status ?? 'baru') === 'ditinjau';
                        @endphp

                        <form action="{{ $sudahDitinjau ? '#' : route('pengaduan.ditinjau', $data->id) }}"
                            method="POST"
                            class="inline"
                            onsubmit="return {{ $sudahDitinjau ? 'false' : 'confirm(\'Tandai pengaduan ini sudah ditinjau?\')' }};">
                        @csrf
                        @method('PATCH')

                        <button type="submit"
                                class="inline-flex items-center h-9 px-3 rounded-md text-xs font-semibold leading-none
                                        focus:outline-none focus:ring-2
                                        {{ $sudahDitinjau
                                            ? 'bg-gray-300 text-gray-600 ring-gray-300 cursor-not-allowed opacity-60 pointer-events-none'
                                            : 'bg-emerald-600 text-white hover:bg-emerald-700 ring-emerald-500' }}"
                                {{ $sudahDitinjau ? 'disabled aria-disabled=true' : '' }}>
                            @if($sudahDitinjau)
                            {{-- ikon centang muted --}}
                            <svg class="w-4 h-4 mr-1.5 -mt-px" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                            </svg>
                            Sudah Ditinjau
                            @else
                            {{-- ikon aktif --}}
                            <svg class="w-4 h-4 mr-1.5 -mt-px" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                            </svg>
                            Tandai Ditinjau
                            @endif
                        </button>
                        </form>

                        </div>
                    </td>
                    @endrole

                    {{-- (Opsional) Aksi Admin --}}
                    @role('admin')
                    <td class="px-4 py-3 text-center">
                        {{-- contoh tempat tombol hapus admin / lainnya --}}
                    </td>
                    @endrole
                    </tr>
                @empty
                    <tr>
                    <td colspan="8" class="px-6 py-10 text-center text-gray-500 dark:text-gray-400">
                        Belum ada pengaduan.
                    </td>
                    </tr>
                @endforelse
                </tbody>

            </table>
          </div>
        </div>
        @endrole

      </div>
    </div>
  </div>
</x-app-layout>
