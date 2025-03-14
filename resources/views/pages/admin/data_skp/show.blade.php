<x-layouts.app title="Data SKP - Detail Peserta {{ $detailPesertaId }}">
    <div class="min-h-screen bg-gray-100 dark:bg-gray-900 flex items-center justify-center p-6">
        <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg p-8 w-full max-w-4xl">
            <h2 class="text-2xl font-semibold text-center mb-6">Data SKP - Detail Peserta {{ $detailPesertaId }}</h2>

            <!-- Flash Message -->
            @if (session('success'))
                <script>
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: '{{ session('success') }}',
                        timer: 3000,
                        showConfirmButton: false
                    });
                </script>
            @endif

            @if ($errors->any())
                <script>
                    Swal.fire({
                        icon: 'error',
                        title: 'Terjadi Kesalahan!',
                        html: `{!! implode('<br>', $errors->all()) !!}`,
                    });
                </script>
            @endif

            <form id="uploadForm" action="{{ route('data_skp.store', $detailPesertaId) }}" method="POST"
                enctype="multipart/form-data">
                @csrf

                <div class="grid grid-cols-2 gap-4">
                    @php
                        $fields = [
                            'upload_surat_permohonan' => 'Surat Permohonan',
                            'upload_sertifikat_pembinaan' => 'Sertifikat Pembinaan',
                            'upload_sk_kerja' => 'SK Kerja',
                            'upload_surat_pernyataan_kerja' => 'Surat Pernyataan Kerja',
                            'upload_rekapitulasi' => 'Rekapitulasi',
                            'upload_pas_foto' => 'Pas Foto',
                            'upload_ijazah_terakhir' => 'Ijazah Terakhir',
                            'upload_paklaring' => 'Paklaring',
                            'upload_surat_pengantar' => 'Surat Pengantar',
                            'upload_pernyataan_personel' => 'Pernyataan Personel',
                            'upload_ktp' => 'KTP',
                            'upload_keahlian_teknis' => 'Keahlian Teknis',
                            'upload_cv' => 'Curriculum Vitae (CV)',
                            'upload_laporan_kegiatan' => 'Laporan Kegiatan',
                            'upload_sk_pensiun' => 'SK Pensiun',
                        ];
                    @endphp

                    @foreach ($fields as $field => $label)
                        <div x-data="{ fileName: '', filePreview: null }" class="space-y-2">
                            <label class="font-semibold text-gray-700">{{ $label }}</label>

                            <!-- Drag & Drop + Klik untuk Open File Dialog -->
                            <div class="border-2 border-dashed border-gray-300 rounded-lg p-4 text-center cursor-pointer bg-gray-50 hover:bg-gray-100"
                                @dragover.prevent
                                @drop.prevent="filePreview = URL.createObjectURL($event.dataTransfer.files[0]); fileName = $event.dataTransfer.files[0].name; $refs.inputField.files = $event.dataTransfer.files"
                                @click="$refs.inputField.click()">
                                <p class="text-gray-500 text-sm">Tarik dan lepas file di sini</p>
                                <p class="text-gray-500 text-sm">atau klik untuk memilih file</p>
                                <input type="file" name="{{ $field }}" x-ref="inputField" class="hidden"
                                    @change="filePreview = URL.createObjectURL($event.target.files[0]); fileName = $event.target.files[0].name">
                            </div>

                            <!-- Preview Nama File + Tombol Batal -->
                            <div x-show="fileName" class="flex items-center justify-between bg-blue-100 p-2 rounded-lg">
                                <span class="text-sm text-gray-700 truncate" x-text="fileName"></span>
                                <button type="button"
                                    @click="fileName = ''; filePreview = null; $refs.inputField.value = ''"
                                    class="text-red-500 text-lg">&times;</button>
                            </div>

                            <!-- Link Preview jika file sudah diunggah -->
                            @if ($dataSKP && $dataSKP->$field)
                                <div class="text-sm text-blue-500">
                                    <a href="{{ $dataSKP->{$field . '_url'} }}" target="_blank"
                                        class="underline">Preview di tab baru</a>
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>

                <div class="flex justify-between items-center mt-6">
                    <a href="{{ route('detail_peserta.index') }}"
                        class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-2 rounded-md">
                        Kembali
                    </a>
                    <button type="button" id="submitButton"
                        class="bg-blue-500 hover:bg-blue-600 text-white px-6 py-2 rounded-md">
                        Simpan Data SKP
                    </button>
                </div>
            </form>

            @if ($dataSKP)
                <form id="deleteForm" action="{{ route('data_skp.destroy', $dataSKP->id) }}" method="POST"
                    class="mt-4">
                    @csrf
                    @method('DELETE')
                    <button type="button" id="deleteButton"
                        class="bg-red-500 hover:bg-red-600 text-white px-6 py-2 rounded-md w-full">
                        Hapus Data SKP
                    </button>
                </form>
            @endif
        </div>
    </div>

    <!-- SweetAlert Script -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        document.getElementById('submitButton').addEventListener('click', function(e) {
            Swal.fire({
                title: 'Simpan Data SKP?',
                text: "Pastikan semua data sudah benar sebelum menyimpan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Simpan!'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('uploadForm').submit();
                }
            });
        });

        document.getElementById('deleteButton').addEventListener('click', function(e) {
            Swal.fire({
                title: 'Hapus Data SKP?',
                text: "Data yang dihapus tidak dapat dikembalikan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, Hapus!'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('deleteForm').submit();
                }
            });
        });
    </script>
</x-layouts.app>
