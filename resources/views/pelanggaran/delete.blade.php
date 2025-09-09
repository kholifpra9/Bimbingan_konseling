@foreach ($pelanggaran as $data)

<div class="modal fade" id="hapusModal_{{ $data->id }}" tabindex="-1" aria-labelledby="hapusModalLabel_{{ $data->id }}" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="hapusModalLabel_{{ $data->id }}">Hapus Data Pelanggaran Siswa</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

                <form method="POST" action="{{ route('pelanggaran.destroy', $data->id) }}" enctype="multipart/form-data">
                    @csrf
                    @method('DELETE')

                    <p>Anda yakin ingin menghapus data pelanggaran dengan nama {{ $data->nama }}?</p>

                    <div class="modal-footer">
                        <x-secondary-button data-bs-dismiss="modal">Batal</x-secondary-button>

                        <button type="submit" class="bg-red-500 text-white font-bold py-2 px-4 rounded hover:bg-red-700">
                            Hapus!
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endforeach