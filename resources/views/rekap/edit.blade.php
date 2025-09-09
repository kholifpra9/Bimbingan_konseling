<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
      @if(auth()->user()->hasRole('gurubk'))
        {{ __('Balas Bimbingan') }}
      @else
        {{ __('Bimbingan Konseling') }}
      @endif
    </h2>
  </x-slot>

  @php
    $isGuruBk = auth()->user()->hasRole('gurubk');
    $siswa    = optional($bimbingan->siswa);
  @endphp

  <div class="py-12">
    <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
      <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-lg sm:rounded-xl">

        {{-- Header card --}}
        <div class="px-6 pt-6 pb-4 border-b border-gray-200 dark:border-gray-700">
          <div class="flex items-center justify-between">
            <div>
              <h3 class="text-lg font-semibold">
                {{ $isGuruBk ? 'Balas Bimbingan' : 'Detail Bimbingan' }}
              </h3>
              <p class="text-sm text-gray-500 dark:text-gray-400">
                {{ $isGuruBk ? 'Berikan tanggapan/lanjutan untuk bimbingan ini.' : 'Ringkasan bimbingan yang diajukan.' }}
              </p>
            </div>
            <div class="flex items-center gap-2">
              <a href="{{ $isGuruBk ? route('rekap.index') : route('dashboard') }}"
                 class="inline-flex items-center gap-2 text-sm px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 hover:bg-gray-100 dark:hover:bg-gray-700 transition">
                ← Kembali
              </a>
              @if($isGuruBk)
                <button form="replyForm" type="submit"
                        class="inline-flex items-center gap-2 text-sm px-5 py-2.5 rounded-lg bg-blue-600 hover:bg-blue-700 text-white font-medium shadow">
                  Simpan
                </button>
              @endif
            </div>
          </div>
        </div>

        <form id="replyForm" action="{{ route('rekap.update', $bimbingan->id) }}" method="POST" class="p-6 space-y-8" novalidate>
          @csrf
          @method('PATCH')

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

              {{-- Nama siswa (read-only) --}}
              <div class="max-w-xl">
                <x-input-label for="nama_siswa" value="Nama Siswa" />
                <input id="nama_siswa" type="text"
                       class="mt-1 block w-full rounded-lg border border-gray-300 dark:border-gray-600 text-black px-3 py-2 bg-gray-50 dark:bg-gray-900"
                       value="{{ $siswa->nama ?? 'Siswa tidak ditemukan' }}" readonly>
              </div>

              {{-- Info tambahan --}}
              <div class="max-w-xl">
                <div class="grid grid-cols-2 gap-4 mt-1">
                  <div>
                    <div class="text-sm text-gray-500 dark:text-gray-400">NIS</div>
                    <div class="font-semibold">{{ $siswa->nis ?? '-' }}</div>
                  </div>
                  <div>
                    <div class="text-sm text-gray-500 dark:text-gray-400">Kelas</div>
                    <div class="font-semibold">{{ $siswa->kelas ?? '-' }}</div>
                  </div>
                </div>
              </div>

              {{-- id_siswa: kunci ke milik bimbingan (hidden) --}}
              <input type="hidden" name="id_siswa" value="{{ $bimbingan->id_siswa }}">
            </div>
          </section>

          <hr class="border-gray-200 dark:border-gray-700">

          {{-- Section: Detail Bimbingan --}}
          <section>
            <h4 class="text-sm font-semibold text-gray-700 dark:text-gray-200 mb-3">Detail Bimbingan</h4>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

              {{-- Jenis Bimbingan (read-only) --}}
              <div class="max-w-xl">
                <x-input-label for="jenis_bimbingan" value="Jenis Bimbingan" />
                <input id="jenis_bimbingan" type="text" name="jenis_bimbingan"
                       value="{{ $bimbingan->jenis_bimbingan }}"
                       class="mt-1 block w-full rounded-lg border border-gray-300 dark:border-gray-600 text-black px-3 py-2 bg-gray-50 dark:bg-gray-900"
                       readonly>
              </div>

              {{-- Tanggal Bimbingan (editable untuk Guru BK; read-only untuk siswa) --}}
              <div class="max-w-xl">
                <x-input-label for="tgl_bimbingan" value="Tanggal Bimbingan" />
                <input type="date" id="tgl_bimbingan" name="tgl_bimbingan"
                       value="{{ $bimbingan->tgl_bimbingan }}"
                       @unless($isGuruBk) disabled @endunless
                       class="mt-1 block w-full rounded-lg border border-gray-300 dark:border-gray-600 text-black px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 {{ $isGuruBk ? '' : 'bg-gray-50 dark:bg-gray-900' }}">
                <x-input-error class="mt-2" :messages="$errors->get('tgl_bimbingan')" />
                @unless($isGuruBk)
                  {{-- kirim nilai jika disabled agar tidak hilang --}}
                  <input type="hidden" name="tgl_bimbingan" value="{{ $bimbingan->tgl_bimbingan }}">
                @endunless
              </div>

              {{-- Keterangan (read-only) --}}
              <div class="md:col-span-2 max-w-3xl">
                <x-input-label for="keterangan" value="Keterangan" />
                <textarea id="keterangan" name="keterangan" rows="4" readonly
                          class="mt-1 block w-full rounded-lg border border-gray-300 dark:border-gray-600 text-black px-3 py-2 bg-gray-50 dark:bg-gray-900">{{ $bimbingan->keterangan }}</textarea>
              </div>
            </div>
          </section>

          <hr class="border-gray-200 dark:border-gray-700">

          {{-- Section: Balasan --}}
          <section>
            <div class="flex items-center justify-between mb-3">
              <h4 class="text-sm font-semibold text-gray-700 dark:text-gray-200">Balasan</h4>
              <span class="text-xs px-2 py-0.5 rounded-full
                    {{ $bimbingan->balasan ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-700' }}">
                {{ $bimbingan->balasan ? 'Sudah dibalas' : 'Belum dibalas' }}
              </span>
            </div>

            <div class="max-w-3xl">
              <x-input-label for="balasan" value="Tanggapan / Rencana Tindak Lanjut" />
              @if($isGuruBk)
                <textarea id="balasan" name="balasan" rows="4" placeholder="Tulis balasan untuk siswa…"
                          class="mt-1 block w-full rounded-lg border border-gray-300 dark:border-gray-600 text-black px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">{{ old('balasan', $bimbingan->balasan) }}</textarea>
              @else
                <textarea id="balasan" rows="4" readonly
                          class="mt-1 block w-full rounded-lg border border-gray-300 dark:border-gray-600 text-black px-3 py-2 bg-gray-50 dark:bg-gray-900">{{ $bimbingan->balasan ?? '-' }}</textarea>
              @endif
              <x-input-error class="mt-2" :messages="$errors->get('balasan')" />
            </div>
          </section>

          {{-- Actions (duplikat bawah untuk kenyamanan) --}}
          <div class="flex items-center justify-end gap-3">
            <a href="{{ $isGuruBk ? route('rekap.index') : route('dashboard') }}"
               class="px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 hover:bg-gray-100 dark:hover:bg-gray-700">
              Batal
            </a>
            @if($isGuruBk)
              <button type="submit"
                      class="px-5 py-2.5 rounded-lg bg-blue-600 hover:bg-blue-700 text-white font-medium shadow">
                Simpan
              </button>
            @endif
          </div>
        </form>

      </div>
    </div>
  </div>
</x-app-layout>
