<x-layouts.app title="Data SKP - Detail Peserta {{ $detailPesertaId }}">
    <div class="min-h-screen bg-gray-100 dark:bg-gray-900 flex items-center justify-center p-6">
        <div class="bg-white dark:bg-gray-800 shadow-lg rounded-lg p-8 w-full max-w-4xl transition-all">
            <h2 class="text-3xl font-bold text-center mb-6 text-gray-800 dark:text-gray-200">Data SKP - Detail Peserta {{ $detailPesertaId }}</h2>

            <!-- Flash Message -->
            @if (session('success'))
                <script>
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: '{{ session('success') }}',
                        timer: 3000,
                        showConfirmButton: false
                    }).then(() => {
                        location.reload();  // Auto-reload setelah notifikasi
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

            <form id="uploadForm" action="{{ route('data_skp.store', $detailPesertaId) }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
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
                        <div x-data="{ fileName: '', filePreview: null }" class="space-y-3">
                            <label class="font-semibold text-gray-700 dark:text-gray-300">{{ $label }}</label>

                            <!-- Drag & Drop Area -->
                            <div class="border-2 border-dashed border-gray-300 dark:border-gray-500 rounded-lg p-4 text-center cursor-pointer bg-gray-50 dark:bg-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 transition"
                                @dragover.prevent
                                @drop.prevent="filePreview = URL.createObjectURL($event.dataTransfer.files[0]); fileName = $event.dataTransfer.files[0].name; $refs.inputField.files = $event.dataTransfer.files"
                                @click="$refs.inputField.click()">
                                <p class="text-gray-500 text-sm">Tarik dan lepas file di sini</p>
                                <p class="text-gray-500 text-sm">atau klik untuk memilih file</p>
                                <input type="file" name="{{ $field }}" x-ref="inputField" class="hidden"
                                    @change="filePreview = URL.createObjectURL($event.target.files[0]); fileName = $event.target.files[0].name">
                            </div>

                            <!-- File Preview -->
                            <div x-show="fileName" class="flex items-center justify-between bg-blue-100 dark:bg-blue-800 p-2 rounded-lg">
                                <span class="text-sm text-gray-700 dark:text-gray-300 truncate" x-text="fileName"></span>
                                <button type="button"
                                    @click="fileName = ''; filePreview = null; $refs.inputField.value = ''"
                                    class="text-red-500 hover:text-red-700 text-lg transition">&times;</button>
                            </div>

                            <!-- Link Preview jika file sudah ada -->
                            @if ($dataSKP && $dataSKP->$field)
                                <div class="text-sm text-blue-500 dark:text-blue-300">
                                    <a href="{{ $dataSKP->{$field . '_url'} }}" target="_blank"
                                        class="underline">Preview di tab baru</a>
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>

                <!-- Tombol Aksi -->
                <div class="flex justify-between items-center mt-8">
                    <a href="{{ route('detail_peserta.index') }}"
                        class="bg-gray-600 hover:bg-gray-700 text-white px-6 py-2 rounded-lg shadow-md transition">
                        Kembali
                    </a>
                    <button type="button" id="submitButton"
                        class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg shadow-md transition">
                        Simpan Data SKP
                    </button>
                </div>
            </form>

            <!-- Tombol Hapus -->
            @if ($dataSKP)
                <form id="deleteForm" action="{{ route('data_skp.destroy', $dataSKP->id) }}" method="POST" class="mt-4">
                    @csrf
                    @method('DELETE')
                    <button type="button" id="deleteButton"
                        class="bg-red-600 hover:bg-red-700 text-white px-6 py-2 rounded-lg w-full shadow-md transition">
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
                    Swal.fire({
                        title: 'Unggah Data Selesai',
                        text: "Data SKP berhasil disimpan.",
                        icon: 'success',
                        showConfirmButton: false,
                        timer: 2000
                    }).then(() => {
                        location.reload();  // Auto-reload halaman setelah upload selesai
                    });
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
