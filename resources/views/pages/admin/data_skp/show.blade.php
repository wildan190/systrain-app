<x-layouts.app title="Data SKP - Detail Peserta {{ $detailPesertaId }}">
    <div class="min-h-screen bg-gray-100 dark:bg-gray-900 flex items-center justify-center p-6">
        <div class="bg-white dark:bg-gray-800 shadow-lg rounded-lg p-8 w-full max-w-4xl transition-all">
            <h2 class="text-3xl font-bold text-center mb-6 text-gray-800 dark:text-gray-200">
                Data SKP - Detail Peserta {{ $detailPesertaId }}
            </h2>

            <!-- Flash Message -->
            <div id="toast-container" class="fixed top-4 right-4 z-50"></div>

            <form id="uploadForm" action="{{ route('data_skp.store', $detailPesertaId) }}" method="POST"
                enctype="multipart/form-data">
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

                            <div class="border-2 border-dashed border-gray-300 dark:border-gray-500 rounded-lg p-4 text-center cursor-pointer bg-gray-50 dark:bg-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 transition"
                                @dragover.prevent
                                @drop.prevent="filePreview = URL.createObjectURL($event.dataTransfer.files[0]); fileName = $event.dataTransfer.files[0].name; $refs.inputField.files = $event.dataTransfer.files"
                                @click="$refs.inputField.click()">
                                <p class="text-gray-500 text-sm">Tarik dan lepas file di sini</p>
                                <p class="text-gray-500 text-sm">atau klik untuk memilih file</p>
                                <input type="file" name="{{ $field }}" x-ref="inputField"
                                    class="hidden file-upload"
                                    @change="filePreview = URL.createObjectURL($event.target.files[0]); fileName = $event.target.files[0].name"
                                    data-field="{{ $field }}">
                            </div>

                            <div x-show="fileName"
                                class="flex items-center justify-between bg-blue-100 dark:bg-blue-800 p-2 rounded-lg">
                                <span class="text-sm text-gray-700 dark:text-gray-300 truncate"
                                    x-text="fileName"></span>
                                <button type="button"
                                    @click="fileName = ''; filePreview = null; $refs.inputField.value = ''"
                                    class="text-red-500 hover:text-red-700 text-lg transition">&times;</button>
                            </div>

                            <div class="relative w-full bg-gray-200 rounded-lg hidden"
                                id="progress-{{ $field }}">
                                <div class="absolute left-0 top-0 h-2 bg-blue-500 rounded-lg transition-all"
                                    style="width: 0%;" id="progress-bar-{{ $field }}"></div>
                                <span
                                    class="absolute left-0 right-0 top-0 bottom-0 flex items-center justify-center text-sm font-semibold text-gray-800 dark:text-gray-200"
                                    id="progress-text-{{ $field }}">0%</span>
                            </div>
                            @if ($dataSKP && $dataSKP->$field)
                                <div class="text-sm text-blue-500 dark:text-blue-300">
                                    <a href="{{ $dataSKP->{$field . '_url'} }}" target="_blank"
                                        class="underline">Preview di tab baru</a>
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>

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
                <form id="deleteForm" action="{{ route('data_skp.destroy', $dataSKP->id) }}" method="POST"
                    class="mt-4">
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

    <!-- SweetAlert & Axios -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

    <script>
        document.getElementById('submitButton').addEventListener('click', function() {
            const files = document.querySelectorAll('.file-upload');
            let totalFiles = 0;
            let uploadedFiles = 0;

            files.forEach(fileInput => {
                if (fileInput.files.length > 0) {
                    totalFiles++;
                }
            });

            if (totalFiles === 0) {
                Swal.fire({
                    title: 'Tidak ada file yang diunggah!',
                    icon: 'warning',
                    confirmButtonText: 'OK'
                });
                return;
            }

            files.forEach(fileInput => {
                const file = fileInput.files[0];
                if (file) {
                    const fieldName = fileInput.getAttribute('data-field');
                    uploadFile(fieldName, file, () => {
                        uploadedFiles++;
                        if (uploadedFiles === totalFiles) {
                            Swal.fire({
                                title: 'Selesai!',
                                text: 'Semua file berhasil diunggah.',
                                icon: 'success',
                                confirmButtonText: 'OK'
                            }).then(() => {
                                location.reload();
                            });
                        }
                    });
                }
            });
        });

        function uploadFile(fieldName, file, callback) {
            const formData = new FormData();
            formData.append(fieldName, file);

            const progressBar = document.getElementById(`progress-${fieldName}`);
            const progressFill = document.getElementById(`progress-bar-${fieldName}`);

            progressBar.classList.remove('hidden');

            axios.post("{{ route('data_skp.store', $detailPesertaId) }}", formData, {
                headers: {
                    'Content-Type': 'multipart/form-data'
                },
                onUploadProgress: function(event) {
                    let percent = Math.round((event.loaded / event.total) * 100);
                    progressFill.style.width = percent + '%';
                    document.getElementById(`progress-text-${fieldName}`).textContent = percent + '%';
                }

            }).then(response => {
                showToast("File " + fieldName + " berhasil diunggah!", "success");
                setTimeout(() => {
                    progressBar.classList.add('hidden');
                }, 2000);
                callback();
            }).catch(error => {
                showToast("Gagal mengunggah " + fieldName, "error");
                callback();
            });
        }

        function showToast(message, type) {
            const toast = document.createElement('div');
            toast.className =
                `bg-${type === 'success' ? 'green' : 'red'}-500 text-white px-4 py-2 rounded-lg shadow-md mb-2 transition-opacity duration-500`;
            toast.innerHTML = message;
            document.getElementById('toast-container').appendChild(toast);
            setTimeout(() => {
                toast.style.opacity = '0';
            }, 3000);
            setTimeout(() => {
                toast.remove();
            }, 3500);
        }

        document.getElementById('deleteButton')?.addEventListener('click', function() {
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
